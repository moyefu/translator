<?php

namespace Moyefu;

use GuzzleHttp\Client;

/**
 * 翻译器抽象基类
 * 所有翻译器的公共基础类，提供通用功能
 */
abstract class Translator implements TranslatorInterface
{
    /**
     * @var string API 密钥
     */
    protected $key;

    /**
     * @var array 附加选项配置
     */
    protected $options = [];

    /**
     * @var Client Guzzle HTTP 客户端实例
     */
    protected $client;

    /**
     * 构造函数
     *
     * @param string|null $key API 密钥（可选）
     * @param array $options 附加选项配置（可选）
     */
    public function __construct($key = null, array $options = [])
    {
        if ($key) {
            $this->key = $key;
        }
        $this->options = $options;
        $this->client = new Client();
    }

    /**
     * 设置 API 密钥
     *
     * @param string $key 翻译服务的 API 密钥
     * @return $this 返回当前实例，支持链式调用
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 设置附加选项
     * 用于配置 HTTP 客户端等选项
     *
     * @param array $options 选项数组，例如 ['timeout' => 10, 'verify' => true]
     * @return $this 返回当前实例，支持链式调用
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * 翻译文本（抽象方法，由子类实现）
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码
     * @param string $to 目标语言代码
     * @return string 翻译后的文本
     */
    abstract public function translate($text, $from, $to);

    /**
     * 获取 Guzzle HTTP 客户端实例
     *
     * @return Client Guzzle HTTP 客户端
     */
    protected function getClient()
    {
        return $this->client;
    }
}
