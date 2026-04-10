<?php

namespace Moyefu;

use GuzzleHttp\Exception\GuzzleException;

class GoogleTranslator extends Translator
{
    const API_URL = 'https://translation.googleapis.com/language/translate/v2';

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

            throw new \Exception('Translation failed');
        } catch (GuzzleException $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
