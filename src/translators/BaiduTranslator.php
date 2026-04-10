<?php

namespace Moyefu\Translators;

use Moyefu\Core\Translator;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 百度翻译器
 * 使用百度翻译 API 进行文本翻译
 */
class BaiduTranslator extends Translator
{
    /**
     * 百度翻译 API 地址
     */
    const API_URL = 'https://fanyi-api.baidu.com/api/trans/vip/translate';

    /**
     * @var string 百度翻译应用 ID
     */
    protected $appId;

    /**
     * 构造函数
     *
     * @param string|null $appId 百度翻译应用 ID（可选）
     * @param string|null $key 百度翻译密钥（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($appId = null, $key = null, array $options = [])
    {
        parent::__construct($key, $options);
        if ($appId) {
            $this->appId = $appId;
        }
    }

    /**
     * 设置百度翻译应用 ID
     *
     * @param string $appId 百度翻译应用 ID
     * @return $this 返回当前实例，支持链式调用
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * 翻译文本
     * 使用百度翻译 API 将文本从源语言翻译为目标语言
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码，例如 'en'（英语）、'zh'（中文）
     * @param string $to 目标语言代码，例如 'zh'（中文）、'en'（英语）
     * @return string 翻译后的文本
     * @throws \Exception 当翻译失败时抛出异常
     */
    public function translate($text, $from, $to)
    {
        $salt = rand(10000, 99999);
        $sign = md5($this->appId . $text . $salt . $this->key);

        try {
            $response = $this->getClient()->request('GET', self::API_URL, [
                'query' => [
                    'q' => $text,
                    'from' => $from,
                    'to' => $to,
                    'appid' => $this->appId,
                    'salt' => $salt,
                    'sign' => $sign
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['trans_result'][0]['dst'])) {
                return $result['trans_result'][0]['dst'];
            }

            throw new \Exception(isset($result['error_msg']) ? $result['error_msg'] : '翻译失败');
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}
