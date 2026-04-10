<?php

require __DIR__ . '/vendor/autoload.php';

use Moyefu\TranslatorFactory;

// 百度翻译示例
$baiduTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_BAIDU, [
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
$googleTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_GOOGLE, [
    'key' => 'your_google_key'
]);

try {
    $result = $googleTranslator->translate('Hello world', 'en', 'zh');
    echo '谷歌翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '谷歌翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 有道翻译示例
$youdaoTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_YOUDAO, [
    'appId' => 'your_youdao_app_id',
    'key' => 'your_youdao_key'
]);

try {
    $result = $youdaoTranslator->translate('Hello world', 'en', 'zh');
    echo '有道翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '有道翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 腾讯翻译示例
$tencentTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_TENCENT, [
    'secretId' => 'your_tencent_secret_id',
    'secretKey' => 'your_tencent_secret_key',
    'options' => [
        'region' => 'ap-beijing'
    ]
]);

try {
    $result = $tencentTranslator->translate('Hello world', 'en', 'zh');
    echo '腾讯翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '腾讯翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 阿里翻译示例
$aliTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_ALI, [
    'accessKeyId' => 'your_ali_access_key_id',
    'accessKeySecret' => 'your_ali_access_key_secret'
]);

try {
    $result = $aliTranslator->translate('Hello world', 'en', 'zh');
    echo '阿里翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '阿里翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 火山翻译示例
$volcengineTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_VOLCENGINE, [
    'accessKeyId' => 'your_volcengine_access_key_id',
    'secretAccessKey' => 'your_volcengine_secret_access_key',
    'options' => [
        'region' => 'cn-beijing'
    ]
]);

try {
    $result = $volcengineTranslator->translate('Hello world', 'en', 'zh');
    echo '火山翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '火山翻译错误: ' . $e->getMessage() . PHP_EOL;
}

// 微软翻译示例
$microsoftTranslator = TranslatorFactory::create(TranslatorFactory::PLATFORM_MICROSOFT, [
    'key' => 'your_microsoft_api_key'
]);

try {
    $result = $microsoftTranslator->translate('Hello world', 'en', 'zh');
    echo '微软翻译结果: ' . $result . PHP_EOL;
} catch (Exception $e) {
    echo '微软翻译错误: ' . $e->getMessage() . PHP_EOL;
}
