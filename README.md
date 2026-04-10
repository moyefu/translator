# Translator Library

[中文文档](README-zh.md) | [English Documentation](README.md)

A PHP library for integrating with various translation APIs (Baidu, Google, Youdao, etc.). This library provides a unified interface to easily switch between different translation services without changing your code.

## Features

- Supports multiple translation APIs (Baidu, Google, Youdao, Tencent, Ali, Volcengine, Microsoft)
- Unified interface for all translators
- Easy to extend with new translation services
- Comprehensive error handling
- Well-documented API
- Unit tests included

## Requirements

- PHP >= 5.6
- GuzzleHttp >= 6.3

## Installation

You can install the library via Composer:

```bash
composer require moyefu/translator
```

## Usage

### Basic Usage

```php
require __DIR__ . '/vendor/autoload.php';

use Moyefu\TranslatorFactory;

// Create Baidu translator
$baiduTranslator = TranslatorFactory::create('baidu', [
    'appId' => 'your_baidu_app_id',
    'key' => 'your_baidu_key'
]);

// Translate text
try {
    $result = $baiduTranslator->translate('Hello world', 'en', 'zh');
    echo 'Translation result: ' . $result;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

// Create Google translator
$googleTranslator = TranslatorFactory::create('google', [
    'key' => 'your_google_key'
]);

// Create Youdao translator
$youdaoTranslator = TranslatorFactory::create('youdao', [
    'appId' => 'your_youdao_app_id',
    'key' => 'your_youdao_key'
]);

// Create Tencent translator
$tencentTranslator = TranslatorFactory::create('tencent', [
    'secretId' => 'your_tencent_secret_id',
    'secretKey' => 'your_tencent_secret_key'
]);

// Create Ali translator
$aliTranslator = TranslatorFactory::create('ali', [
    'accessKeyId' => 'your_ali_access_key_id',
    'accessKeySecret' => 'your_ali_access_key_secret'
]);

// Create Volcengine translator
$volcengineTranslator = TranslatorFactory::create('volcengine', [
    'accessKeyId' => 'your_volcengine_access_key_id',
    'accessKeySecret' => 'your_volcengine_access_key_secret'
]);

// Create Microsoft translator
$microsoftTranslator = TranslatorFactory::create('microsoft', [
    'apiKey' => 'your_microsoft_api_key',
    'endpoint' => 'your_microsoft_endpoint'
]);
```

### Advanced Usage

```php
// Set additional options
$translator->setOptions([
    'timeout' => 10, // 10 seconds timeout
    'verify' => true // Verify SSL certificates
]);

// Change API key dynamically
$translator->setKey('new_api_key');

// Translate multiple sentences
$texts = [
    'Hello world',
    'How are you?',
    'I am fine, thank you.'
];

foreach ($texts as $text) {
    try {
        $result = $translator->translate($text, 'en', 'zh');
        echo "Original: $text\n";
        echo "Translation: $result\n\n";
    } catch (Exception $e) {
        echo "Error translating '$text': " . $e->getMessage() . "\n";
    }
}
```

### Supported Translators

| Translator | API Reference | Required Configuration |
|------------|---------------|------------------------|
| **baidu** | [Baidu Translate API](docs/platforms/baidu.md) | `['appId' => '...', 'key' => '...']` |
| **google** | [Google Translate API](docs/platforms/google.md) | `['key' => '...']` |
| **youdao** | [Youdao Translate API](docs/platforms/youdao.md) | `['appId' => '...', 'key' => '...']` |
| **tencent** | [Tencent Translate API](docs/platforms/tencent.md) | `['secretId' => '...', 'secretKey' => '...']` |
| **ali** | [Ali Translate API](docs/platforms/ali.md) | `['accessKeyId' => '...', 'accessKeySecret' => '...']` |
| **volcengine** | [Volcengine Translate API](docs/platforms/volcengine.md) | `['accessKeyId' => '...', 'accessKeySecret' => '...']` |
| **microsoft** | [Microsoft Translate API](docs/platforms/microsoft.md) | `['apiKey' => '...', 'endpoint' => '...']` |

## API Reference

### TranslatorFactory::create($type, array $config = [])

Create a translator instance.

- `$type`: Translator type (baidu, google, youdao, tencent, ali, volcengine, microsoft)
- `$config`: Configuration array
  - For Baidu: `['appId' => '...', 'key' => '...']`
  - For Google: `['key' => '...']`
  - For Youdao: `['appId' => '...', 'key' => '...']`
  - For Tencent: `['secretId' => '...', 'secretKey' => '...']`
  - For Ali: `['accessKeyId' => '...', 'accessKeySecret' => '...']`
  - For Volcengine: `['accessKeyId' => '...', 'accessKeySecret' => '...']`
  - For Microsoft: `['apiKey' => '...', 'endpoint' => '...']`

### TranslatorInterface

All translators implement the `TranslatorInterface` with the following methods:

- `translate($text, $from, $to)`: Translate text from source language to target language
  - `$text`: Text to translate
  - `$from`: Source language code (e.g., 'en', 'zh')
  - `$to`: Target language code (e.g., 'zh', 'en')
  - Returns: Translated text
  - Throws: Exception if translation fails

- `setKey($key)`: Set API key
  - `$key`: API key for the translation service

- `setOptions(array $options)`: Set additional options
  - `$options`: Array of options (e.g., timeout, verify)

## Testing

Run the tests with:

```bash
vendor/bin/phpunit tests/TranslatorTest.php
```

## Example

Check out the [example.php](example.php) file for a complete example of how to use the library.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

MIT
