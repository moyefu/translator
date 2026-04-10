<?php

namespace Moyefu\Translators;

use Moyefu\Core\Translator;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 谷歌翻译器
 * 使用 Google 翻译 API 进行文本翻译
 */
class GoogleTranslator extends Translator
{
    /**
     * Google 翻译 API 地址
     */
    const API_URL = 'https://translation.googleapis.com/language/translate/v2';

    /**
     * 翻译文本
     * 使用 Google 翻译 API 将文本从源语言翻译为目标语言
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
                'query' => [
                    'key' => $this->key
                ],
                'json' => [
                    'q' => $text,
                    'source' => $from,
                    'target' => $to,
                    'format' => 'text'
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['data']['translations'][0]['translatedText'])) {
                return $result['data']['translations'][0]['translatedText'];
            }

            throw new \Exception('翻译失败');
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}
