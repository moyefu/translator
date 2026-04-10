<?php

namespace Moyefu;

interface TranslatorInterface
{
    /**
     * Translate text from source language to target language
     *
     * @param string $text
     * @param string $from
     * @param string $to
     * @return string
     */
    public function translate($text, $from, $to);

    /**
     * Set API key
     *
     * @param string $key
     * @return $this
     */
    public function setKey($key);

    /**
     * Set additional options
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options);
}
