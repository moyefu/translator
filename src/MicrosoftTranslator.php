<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 微软翻译器
 * 使用微软 Azure 翻译 API 进行文本翻译
 */
class MicrosoftTranslator extends Translator
{
    /**
     * 微软翻译 API 地址
     */
    const API_URL = 'https://api.cognitive.microsofttranslator.com/translate';

    /**
     * 微软翻译 API 版本
     */
    protected $version = '3.0';

    /**
     * 构造函数
     *
     * @param string|null $key 微软 Azure 翻译 API 密钥（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($key = null, array $options = [])
    {
        parent::__construct($key, $options);
    }

    /**
     * 翻译文本
     * 使用微软 Azure 翻译 API 将文本从源语言翻译为目标语言
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码，例如 'en'（英语）、'zh'（中文）
     * @param string $to 目标语言代码，例如 'zh'（中文）、'en'（英语）
     * @return string 翻译后的文本
     * @throws \Exception 当翻译失败时抛出异常
     */
    public function translate($text, $from, $to)
    {
        try {
            $response = $this->getClient()->request('POST', self::API_URL, [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => $this->key,
                    'Content-Type' => 'application/json',
                    'X-ClientTraceId' => uniqid()
                ],
                'query' => [
                    'api-version' => $this->version,
                    'from' => $from,
                    'to' => $to
                ],
                'json' => [
                    [
                        'text' => $text
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result[0]['translations'][0]['text'])) {
                return $result[0]['translations'][0]['text'];
            }

            throw new \Exception('翻译失败');
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}