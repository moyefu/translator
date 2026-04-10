<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 阿里翻译器
 * 使用阿里巴巴云翻译 API 进行文本翻译
 */
class AliTranslator extends Translator
{
    /**
     * 阿里翻译 API 地址
     */
    const API_URL = 'http://mt.cn-shanghai.aliyuncs.com';

    /**
     * 阿里云 API 版本
     */
    protected $version = '2018-04-08';

    /**
     * 阿里云 AccessKey ID
     */
    protected $accessKeyId;

    /**
     * 构造函数
     *
     * @param string|null $accessKeyId 阿里云 AccessKey ID（可选）
     * @param string|null $accessKeySecret 阿里云 AccessKey Secret（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($accessKeyId = null, $accessKeySecret = null, array $options = [])
    {
        parent::__construct($accessKeySecret, $options);
        if ($accessKeyId) {
            $this->accessKeyId = $accessKeyId;
        }
    }

    /**
     * 设置阿里云 AccessKey ID
     *
     * @param string $accessKeyId 阿里云 AccessKey ID
     * @return $this 返回当前实例，支持链式调用
     */
    public function setAccessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
        return $this;
    }

    /**
     * 生成阿里云 API 签名
     *
     * @param array $params API 参数
     * @return array 包含签名的完整参数
     */
    protected function generateSignature(array $params)
    {
        $params['Format'] = 'JSON';
        $params['Version'] = $this->version;
        $params['AccessKeyId'] = $this->accessKeyId;
        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        $params['SignatureMethod'] = 'HMAC-SHA1';
        $params['SignatureVersion'] = '1.0';
        $params['SignatureNonce'] = uniqid();
        
        ksort($params);
        $canonicalizedQueryString = '';
        foreach ($params as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $canonicalizedQueryString = substr($canonicalizedQueryString, 1);
        
        $stringToSign = 'GET&' . $this->percentEncode('/') . '&' . $this->percentEncode($canonicalizedQueryString);
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $this->key . '&', true));
        $params['Signature'] = $signature;
        
        return $params;
    }

    /**
     * URL 编码
     *
     * @param string $string 要编码的字符串
     * @return string 编码后的字符串
     */
    protected function percentEncode($string)
    {
        $string = urlencode($string);
        $string = preg_replace('/\+/', '%20', $string);
        $string = preg_replace('/\*/', '%2A', $string);
        $string = preg_replace('/%7E/', '~', $string);
        return $string;
    }

    /**
     * 翻译文本
     * 使用阿里巴巴云翻译 API 将文本从源语言翻译为目标语言
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码，例如 'en'（英语）、'zh'（中文）
     * @param string $to 目标语言代码，例如 'zh'（中文）、'en'（英语）
     * @return string 翻译后的文本
     * @throws \Exception 当翻译失败时抛出异常
     */
    public function translate($text, $from, $to)
    {
        $params = [
            'Action' => 'TranslateGeneral',
            'SourceLanguage' => $from,
            'TargetLanguage' => $to,
            'FormatType' => 'text',
            'SourceText' => $text
        ];
        
        $params = $this->generateSignature($params);

        try {
            $response = $this->getClient()->request('GET', self::API_URL, [
                'query' => $params
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['Data']['Translated'])) {
                return $result['Data']['Translated'];
            }

            $errorMsg = isset($result['Message']) ? $result['Message'] : '翻译失败';
            throw new \Exception($errorMsg);
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}