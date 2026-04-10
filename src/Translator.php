<?php

namespace Translate;

use GuzzleHttp\Client;

abstract class Translator implements TranslatorInterface
{
    protected $key;
    protected $options = [];
    protected $client;

    public function __construct($key = null, array $options = [])
    {
        if ($key) {
            $this->key = $key;
        }
        $this->options = $options;
        $this->client = new Client();
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    abstract public function translate($text, $from, $to);

    protected function getClient()
    {
        return $this->client;
    }
}
