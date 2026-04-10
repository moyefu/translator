<?php

require __DIR__ . '/vendor/autoload.php';

use Moyefu\TranslatorFactory;

// 百度翻译示例
$baiduTranslator = TranslatorFactory::create('baidu', [
    'appId' => 'your_baidu_app_id',
    'key' => 'your_baidu_key'
]);

try {
    $result = $baiduTranslator->translate('Hello world', 'en', 'zh');
    echo '百度翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '百度翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 谷歌翻译示例
$googleTranslator = TranslatorFactory::create('google', [
    'key' => 'your_google_key'
]);

try {
    $result = $googleTranslator->translate('Hello world', 'en', 'zh');
    echo '谷歌翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '谷歌翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 有道翻译示例
$youdaoTranslator = TranslatorFactory::create('youdao', [
    'appId' => 'your_youdao_app_id',
    'key' => 'your_youdao_key'
]);

try {
    $result = $youdaoTranslator->translate('Hello world', 'en', 'zh');
    echo '有道翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '有道翻译错误: ' . $e->getMessage() . PHP_EOL;
}
