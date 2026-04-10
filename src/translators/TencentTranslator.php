<?php

namespace Moyefu\Translators;

use Moyefu\Core\Translator;

use GuzzleHttp\Exception\GuzzleException;

/**
 * 腾讯翻译器
 * 使用腾讯云翻译 API 进行文本翻译
 */
class TencentTranslator extends Translator
{
    /**
     * 腾讯翻译 API 地址
     */
    const API_URL = 'https://tmt.tencentcloudapi.com';

    /**
     * 腾讯云地域
     */
    protected $region = 'ap-beijing';

    /**
     * 腾讯云 API 版本
     */
    protected $version = '2018-03-21';

    /**
     * 腾讯云 SecretId
     */
    protected $secretId;

    /**
     * 构造函数
     *
     * @param string|null $secretId 腾讯云 SecretId（可选）
     * @param string|null $secretKey 腾讯云 SecretKey（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($secretId = null, $secretKey = null, array $options = [])
    {
        parent::__construct($secretKey, $options);
        if ($secretId) {
            $this->secretId = $secretId;
        }
        if (isset($options['region'])) {
            $this->region = $options['region'];
        }
    }

    /**
     * 设置腾讯云 SecretId
     *
     * @param string $secretId 腾讯云 SecretId
     * @return $this 返回当前实例，支持链式调用
     */
    public function setSecretId($secretId)
    {
        $this->secretId = $secretId;
        return $this;
    }

    /**
     * 设置腾讯云地域
     *
     * @param string $region 腾讯云地域，例如 'ap-beijing'、'ap-shanghai' 等
     * @return $this 返回当前实例，支持链式调用
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * 生成腾讯云 API 签名
     *
     * @param array $params API 参数
     * @return array 包含签名的完整参数
     */
    protected function generateSignature(array $params)
    {
        $params['SecretId'] = $this->secretId;
        $params['Timestamp'] = time();
        $params['Nonce'] = rand(10000, 99999);
        $params['Region'] = $this->region;
        $params['Version'] = $this->version;
        
        ksort($params);
        $stringToSign = 'GET' . self::API_URL . '/?' . http_build_query($params);
        $params['Signature'] = base64_encode(hash_hmac('sha1', $stringToSign, $this->key, true));
        
        return $params;
    }

    /**
     * 翻译文本
     * 使用腾讯云翻译 API 将文本从源语言翻译为目标语言
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
            'Action' => 'TextTranslate',
            'SourceText' => $text,
            'Source' => $from,
            'Target' => $to,
            'ProjectId' => 0
        ];
        
        $params = $this->generateSignature($params);

        try {
            $response = $this->getClient()->request('GET', self::API_URL, [
                'query' => $params
            ]);

            $result = json_decode($response->getBody(), true);
            if (isset($result['Response']['TargetText'])) {
                return $result['Response']['TargetText'];
            }

            $errorMsg = isset($result['Response']['Error']['Message']) ? $result['Response']['Error']['Message'] : '翻译失败';
            throw new \Exception($errorMsg);
        } catch (GuzzleException $e) {
            throw new \Exception('API 请求失败: ' . $e->getMessage());
        }
    }
}