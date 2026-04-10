<?php

namespace Moyefu\Core;

/**
 * 翻译器接口
 * 定义所有翻译器必须实现的方法
 */
interface TranslatorInterface
{
    /**
     * 翻译文本
     * 将文本从源语言翻译为目标语言
     *
     * @param string $text 要翻译的文本内容
     * @param string $from 源语言代码，例如 'en'（英语）、'zh'（中文）
     * @param string $to 目标语言代码，例如 'zh'（中文）、'en'（英语）
     * @return string 翻译后的文本
     * @throws \Exception 当翻译失败时抛出异常
     */
    public function translate($text, $from, $to);

    /**
     * 设置 API 密钥
     *
     * @param string $key 翻译服务的 API 密钥
     * @return $this 返回当前实例，支持链式调用
     */
    public function setKey($key);

    /**
     * 设置附加选项
     * 用于配置 HTTP 客户端等选项
     *
     * @param array $options 选项数组，例如 ['timeout' => 10, 'verify' => true]
     * @return $this 返回当前实例，支持链式调用
     */
    public function setOptions(array $options);
}
