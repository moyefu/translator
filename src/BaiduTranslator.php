<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

class BaiduTranslator extends Translator
{
    const API_URL = 'https://fanyi-api.baidu.com/api/trans/vip/translate';

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

            throw new \Exception(isset($result['error_msg']) ? $result['error_msg'] : 'Translation failed');
        } catch (GuzzleException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
