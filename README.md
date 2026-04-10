# Translator Library

A PHP library for integrating with various translation APIs (Baidu, Google, Youdao, etc.)

## Requirements

- PHP >= 5.6
- GuzzleHttp >= 6.3

## Installation

```bash
composer require translate/translator
```

## Usage

### Basic Usage

```php
require __DIR__ . '/vendor/autoload.php';

use Translate\TranslatorFactory;

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
```

### Supported Translators

- **baidu**: Baidu Translate API
- **google**: Google Translate API
- **youdao**: Youdao Translate API

## API Reference

### TranslatorFactory::create($type, array $config = [])

Create a translator instance.

- `$type`: Translator type (baidu, google, youdao)
- `$config`: Configuration array
  - For Baidu: `['appId' => '...', 'key' => '...']`
  - For Google: `['key' => '...']`
  - For Youdao: `['appId' => '...', 'key' => '...']`

### TranslatorInterface

All translators implement the `TranslatorInterface` with the following methods:

- `translate($text, $from, $to)`: Translate text from source language to target language
- `setKey($key)`: Set API key
- `setOptions(array $options)`: Set additional options

## Testing

Run the tests with:

```bash
vendor/bin/phpunit tests/TranslatorTest.php
```

## License

MIT
