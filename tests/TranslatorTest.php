<?php

namespace Moyefu\Tests;

use PHPUnit\Framework\TestCase;
use Moyefu\TranslatorFactory;

class TranslatorTest extends TestCase
{
    /**
     * Test translator factory creation
     */
    public function testFactoryCreation()
    {
        // Test Baidu translator creation
        $baiduTranslator = TranslatorFactory::create('baidu', [
            'appId' => 'test_app_id',
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\BaiduTranslator', $baiduTranslator);

        // Test Google translator creation
        $googleTranslator = TranslatorFactory::create('google', [
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $googleTranslator);

        // Test Youdao translator creation
        $youdaoTranslator = TranslatorFactory::create('youdao', [
            'appId' => 'test_app_id',
            'key' => 'test_key'
        ]);
        $this->assertInstanceOf('Moyefu\YoudaoTranslator', $youdaoTranslator);
    }

    /**
     * Test invalid translator type
     */
    public function testInvalidTranslatorType()
    {
        $this->expectException(\InvalidArgumentException::class);
        TranslatorFactory::create('invalid');
    }

    /**
     * Test translator methods
     */
    public function testTranslatorMethods()
    {
        $translator = TranslatorFactory::create('google', [
            'key' => 'test_key'
        ]);

        // Test setKey method
        $translator->setKey('new_key');
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $translator);

        // Test setOptions method
        $translator->setOptions(['timeout' => 10]);
        $this->assertInstanceOf('Moyefu\GoogleTranslator', $translator);
    }
}
