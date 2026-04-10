# 翻译器库

[English Documentation](README.md) | [中文文档](README-zh.md)

一个用于集成各种翻译 API（百度、谷歌、有道等）的 PHP 库。这个库提供了一个统一的接口，可以在不更改代码的情况下轻松切换不同的翻译服务。

## 特性

- 支持多个翻译 API（百度、谷歌、有道、腾讯、阿里、火山引擎、微软）
- 所有翻译器的统一接口
- 易于扩展新的翻译服务
- 全面的错误处理
- 详细的 API 文档
- 包含单元测试

## 要求

- PHP >= 5.6
- GuzzleHttp >= 6.3

## 安装

您可以通过 Composer 安装该库：

```bash
composer require moyefu/translator
```

## 使用

### 基本用法

```php
require __DIR__ . '/vendor/autoload.php';

use Moyefu\TranslatorFactory;

// 创建百度翻译器
$baiduTranslator = TranslatorFactory::create('baidu', [
    'appId' => 'your_baidu_app_id',
    'key' => 'your_baidu_key'
]);

// 翻译文本
try {
    $result = $baiduTranslator->translate('Hello world', 'en', 'zh');
    echo '翻译结果: ' . $result;
} catch (Exception $e) {
    echo '错误: ' . $e->getMessage();
}

// 创建谷歌翻译器
$googleTranslator = TranslatorFactory::create('google', [
    'key' => 'your_google_key'
]);

// 创建有道翻译器
$youdaoTranslator = TranslatorFactory::create('youdao', [
    'appId' => 'your_youdao_app_id',
    'key' => 'your_youdao_key'
]);

// 创建腾讯翻译器
$tencentTranslator = TranslatorFactory::create('tencent', [
    'secretId' => 'your_tencent_secret_id',
    'secretKey' => 'your_tencent_secret_key'
]);

// 创建阿里翻译器
$aliTranslator = TranslatorFactory::create('ali', [
    'accessKeyId' => 'your_ali_access_key_id',
    'accessKeySecret' => 'your_ali_access_key_secret'
]);

// 创建火山引擎翻译器
$volcengineTranslator = TranslatorFactory::create('volcengine', [
    'accessKeyId' => 'your_volcengine_access_key_id',
    'accessKeySecret' => 'your_volcengine_access_key_secret'
]);

// 创建微软翻译器
$microsoftTranslator = TranslatorFactory::create('microsoft', [
    'apiKey' => 'your_microsoft_api_key',
    'endpoint' => 'your_microsoft_endpoint'
]);
```

### 高级用法

```php
// 设置附加选项
$translator->setOptions([
    'timeout' => 10, // 10秒超时
    'verify' => true // 验证SSL证书
]);

// 动态更改API密钥
$translator->setKey('new_api_key');

// 翻译多个句子
$texts = [
    'Hello world',
    'How are you?',
    'I am fine, thank you.'
];

foreach ($texts as $text) {
    try {
        $result = $translator->translate($text, 'en', 'zh');
        echo "原文: $text\n";
        echo "翻译: $result\n\n";
    } catch (Exception $e) {
        echo "翻译 '$text' 时出错: " . $e->getMessage() . "\n";
    }
}
```

### 支持的翻译器

| 翻译器 | API 参考 | 必需配置 |
|--------|----------|----------|
| **baidu** | [百度翻译 API](docs/platforms/baidu.md) | `['appId' => '...', 'key' => '...']` |
| **google** | [谷歌翻译 API](docs/platforms/google.md) | `['key' => '...']` |
| **youdao** | [有道翻译 API](docs/platforms/youdao.md) | `['appId' => '...', 'key' => '...']` |
| **tencent** | [腾讯翻译 API](docs/platforms/tencent.md) | `['secretId' => '...', 'secretKey' => '...']` |
| **ali** | [阿里翻译 API](docs/platforms/ali.md) | `['accessKeyId' => '...', 'accessKeySecret' => '...']` |
| **volcengine** | [火山引擎翻译 API](docs/platforms/volcengine.md) | `['accessKeyId' => '...', 'accessKeySecret' => '...']` |
| **microsoft** | [微软翻译 API](docs/platforms/microsoft.md) | `['apiKey' => '...', 'endpoint' => '...']` |

## API 参考

### TranslatorFactory::create($type, array $config = [])

创建翻译器实例。

- `$type`: 翻译器类型 (baidu, google, youdao, tencent, ali, volcengine, microsoft)
- `$config`: 配置数组
  - 对于百度: `['appId' => '...', 'key' => '...']`
  - 对于谷歌: `['key' => '...']`
  - 对于有道: `['appId' => '...', 'key' => '...']`
  - 对于腾讯: `['secretId' => '...', 'secretKey' => '...']`
  - 对于阿里: `['accessKeyId' => '...', 'accessKeySecret' => '...']`
  - 对于火山引擎: `['accessKeyId' => '...', 'accessKeySecret' => '...']`
  - 对于微软: `['apiKey' => '...', 'endpoint' => '...']`

### TranslatorInterface

所有翻译器都实现了 `TranslatorInterface` 接口，包含以下方法：

- `translate($text, $from, $to)`: 将文本从源语言翻译到目标语言
  - `$text`: 要翻译的文本
  - `$from`: 源语言代码 (例如: 'en', 'zh')
  - `$to`: 目标语言代码 (例如: 'zh', 'en')
  - 返回: 翻译后的文本
  - 抛出: 如果翻译失败则抛出异常

- `setKey($key)`: 设置 API 密钥
  - `$key`: 翻译服务的 API 密钥

- `setOptions(array $options)`: 设置附加选项
  - `$options`: 选项数组 (例如: timeout, verify)

## 测试

运行测试：

```bash
vendor/bin/phpunit tests/TranslatorTest.php
```

## 示例

查看 [example.php](example.php) 文件，了解如何使用该库的完整示例。

## 贡献

欢迎贡献！请随时提交 Pull Request。

## 许可证

MIT