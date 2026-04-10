<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 火山翻译器
 * 使用字节跳动火山引擎翻译 API 进行文本翻译
 */
class VolcengineTranslator extends Translator
{
    /**
     * 火山翻译 API 地址
     */
    const API_URL = 'https://translate.volcengineapi.com';

    /**
     * 火山引擎 API 版本
     */
    protected $version = '2020-06-01';

    /**
     * 火山引擎 ServiceName
     */
    protected $serviceName = 'translate';

    /**
     * 火山引擎 Region
     */
    protected $region = 'cn-beijing';

    /**
     * 火山引擎 AccessKey ID
     */
    protected $accessKeyId;

    /**
     * 构造函数
     *
     * @param string|null $accessKeyId 火山引擎 AccessKey ID（可选）
     * @param string|null $secretAccessKey 火山引擎 SecretAccessKey（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($accessKeyId = null, $secretAccessKey = null, array $options = [])
    {
        parent::__construct($secretAccessKey, $options);
        if ($accessKeyId) {
            $this->accessKeyId = $accessKeyId;
        }
        if (isset($options['region'])) {
            $this->region = $options['region'];
        }
    }

    /**
     * 设置火山引擎 AccessKey ID
     *
     * @param string $accessKeyId 火山引擎 AccessKey ID
     * @return $this 返回当前实例，支持链式调用
     */
    public function setAccessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
        return $this;
    }

    /**
     * 设置火山引擎 Region
     *
     * @param string $region 火山引擎 Region，例如 'cn-beijing'、'cn-shanghai' 等
     * @return $this 返回当前实例，支持链式调用
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * 生成火山引擎 API 签名
     *
     * @param string $method HTTP 方法
     * @param string $path API 路径
     * @param array $headers HTTP 头
     * @param array $query Query 参数
     * @param array $body 请求体
     * @return string 签名
     */
    protected function generateSignature($method, $path, $headers, $query, $body)
    {
        $canonicalRequest = $method . "\n" .
                           $path . "\n" .
                           http_build_query($query) . "\n" .
                           $this->canonicalizeHeaders($headers) . "\n" .
                           $this->getSignedHeaders($headers) . "\n" .
                           base64_encode(hash('sha256', json_encode($body), true));
        
        $date = gmdate('Ymd\THis\Z');
        $credentialScope = gmdate('Ymd') . '/' . $this->region . '/' . $this->serviceName . '/request';
        $stringToSign = 'HMAC-SHA256' . "\n" .
                       $date . "\n" .
                       $credentialScope . "\n" .
                       base64_encode(hash('sha256', $canonicalRequest, true));
        
        $signingKey = hash_hmac('sha256', gmdate('Ymd'), 'VOLC' . $this->key, true);
        $signingKey = hash_hmac('sha256', $this->region, $signingKey, true);
        $signingKey = hash_hmac('sha256', $this->serviceName, $signingKey, true);
        $signingKey = hash_hmac('sha256', 'request', $signingKey, true);
        
        return base64_encode(hash_hmac('sha256', $stringToSign, $signingKey, true));
    }

    /**
     * 规范化 HTTP 头
     *
     * @param array $headers HTTP 头
     * @return string 规范化后的 HTTP 头
     */
    protected function canonicalizeHeaders($headers)
    {
        ksort($headers);
        $result = '';
        foreach ($headers as $key => $value) {
            $result .= strtolower($key) . ':' . trim($value) . "\n";
        }
        return $result;
    }

    /**
     * 获取签名的 HTTP 头
     *
     * @param array $headers HTTP 头
     * @return string 签名的 HTTP 头
     */
    protected function getSignedHeaders($headers)
    {
        ksort($headers);
        $result = [];
        foreach (array_keys($headers) as $key) {
            $result[] = strtolower($key);
        }
        return implode(';', $result);
    }

    /**
     * 翻译文本
     * 使用火山引擎翻译 API 将文本从源语言翻译为目标语言
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码，例如 'en'（英语）、'zh'（中文）
     * @param string $to 目标语言代码，例如 'zh'（中文）、'en'（英语）
     * @return string 翻译后的文本
     * @throws \Exception 当翻译失败时抛出异常
     */
    public function translate($text, $from, $to)
    {
        $path = '/';
        $method = 'POST';
        $date = gmdate('Ymd\THis\Z');
        
        $headers = [
            'Content-Type' => 'application/json',
            'Host' => 'translate.volcengineapi.com',
            'X-Top-Request-Id' => uniqid(),
            'X-Top-Service' => $this->serviceName,
            'X-Top-Region' => $this->region,
            'X-Top-Account-Id' => '',
            'X-Top-TimeStamp' => $date
        ];
        
        $body = [
            'SourceLanguage' => $from,
            'TargetLanguage' => $to,
            'TextList' => [$text]
        ];
        
        $signature = $this->generateSignature($method, $path, $headers, [], $body);
        $headers['Authorization'] = 'HMAC-SHA256 Credential=' . $this->accessKeyId . '/' . gmdate('Ymd') . '/' . $this->region . '/' . $this->serviceName . '/request, SignedHeaders=' . $this->getSignedHeaders($headers) . ', Signature=' . $signature;

        try {
            $response = $this->getClient()->request($method, self::API_URL, [
                'headers' => $headers,
                'json' => $body
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['TranslationList'][0]['Translation'])) {
                return $result['TranslationList'][0]['Translation'];
            }

            $errorMsg = isset($result['Message']) ? $result['Message'] : '翻译失败';
            throw new \Exception($errorMsg);
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}