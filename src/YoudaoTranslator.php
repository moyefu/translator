<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 有道翻译器
 * 使用有道翻译 API 进行文本翻译
 */
class YoudaoTranslator extends Translator
{
    /**
     * 有道翻译 API 地址
     */
    const API_URL = 'https://openapi.youdao.com/api';

    /**
     * @var string 有道翻译应用 ID
     */
    protected $appId;

    /**
     * 构造函数
     *
     * @param string|null $appId 有道翻译应用 ID（可选）
     * @param string|null $key 有道翻译密钥（可选）
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
     * 设置有道翻译应用 ID
     *
     * @param string $appId 有道翻译应用 ID
     * @return $this 返回当前实例，支持链式调用
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * 翻译文本
     * 使用有道翻译 API 将文本从源语言翻译为目标语言
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
            $response = $this->getClient()->request('POST', self::API_URL, [
                'form_params' => [
                    'q' => $text,
                    'from' => $from,
                    'to' => $to,
                    'appKey' => $this->appId,
                    'salt' => $salt,
                    'sign' => $sign
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['translation'][0])) {
                return $result['translation'][0];
            }

            throw new \Exception(isset($result['errorCode']) ? '错误: ' . $result['errorCode'] : '翻译失败');
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}
