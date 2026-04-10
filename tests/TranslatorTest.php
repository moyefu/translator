<?php

namespace Moyefu\Tests;

use PHPUnit\Framework\TestCase;
use Moyefu\TranslatorFactory;

class TranslatorTest extends TestCase
{
    /**
     * 测试翻译器工厂创建
     */
    public function testFactoryCreation()
    {
        // 测试百度翻译器创建
        $baiduTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_BAIDU, [
            'appId' => 'test_app_id',
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\BaiduTranslator', $baiduTranslator);

        // 测试谷歌翻译器创建
        $googleTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_GOOGLE, [
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $googleTranslator);

        // 测试有道翻译器创建
        $youdaoTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_YOUDAO, [
            'appId' => 'test_app_id',
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\YoudaoTranslator', $youdaoTranslator);
    }

    /**
     * 测试无效的翻译器类型
     */
    public function testInvalidTranslatorType()
    {
        $this->expectException(\InvalidArgumentException::class);
        TranslatorFactory::create('invalid');
    }

    /**
     * 测试翻译器方法
     */
    public function testTranslatorMethods()
    {
        $translator = TranslatorFactory::create(TranslatorFactory::PLATFORM_GOOGLE, [
            'key' => 'test_key'
        ]);

        // 测试 setKey 方法
        $translator->setKey('new_key');
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $translator);

        // 测试 setOptions 方法
        $translator->setOptions(['timeout' => 10]);
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $translator);
    }
}
