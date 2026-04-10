<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

class YoudaoTranslator extends Translator
{
    const API_URL = 'https://openapi.youdao.com/api';

    protected $appId;

    public function __construct($appId = null, $key = null, array $options = [])
    {
        parent::__construct($key, $options);
        if ($appId) {
            $this->appId = $appId;
        }
    }

    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

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

            throw new \Exception(isset($result['errorCode']) ? 'Error: ' . $result['errorCode'] : 'Translation failed');
        } catch (GuzzleException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
