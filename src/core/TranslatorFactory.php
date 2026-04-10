<?php

namespace Moyefu\Core;

use Moyefu\Translators\AliTranslator;
use Moyefu\Translators\BaiduTranslator;
use Moyefu\Translators\GoogleTranslator;
use Moyefu\Translators\MicrosoftTranslator;
use Moyefu\Translators\TencentTranslator;
use Moyefu\Translators\VolcengineTranslator;
use Moyefu\Translators\YoudaoTranslator;

/**
 * 翻译器工厂类
 * 用于创建不同翻译平台的翻译器实例
 */
class TranslatorFactory
{
    /**
     * 百度翻译平台
     */
    const PLATFORM_BAIDU = 'baidu';

    /**
     * 谷歌翻译平台
     */
    const PLATFORM_GOOGLE = 'google';

    /**
     * 有道翻译平台
     */
    const PLATFORM_YOUDAO = 'youdao';

    /**
     * 腾讯翻译平台
     */
    const PLATFORM_TENCENT = 'tencent';

    /**
     * 阿里翻译平台
     */
    const PLATFORM_ALI = 'ali';

    /**
     * 火山翻译平台
     */
    const PLATFORM_VOLCENGINE = 'volcengine';

    /**
     * 微软翻译平台
     */
    const PLATFORM_MICROSOFT = 'microsoft';

    /**
     * 创建翻译器实例
     *
     * @param string $type 翻译平台类型，使用常量：
     *                     - TranslatorFactory::PLATFORM_BAIDU  百度翻译
     *                     - TranslatorFactory::PLATFORM_GOOGLE 谷歌翻译
     *                     - TranslatorFactory::PLATFORM_YOUDAO 有道翻译
     *                     - TranslatorFactory::PLATFORM_TENCENT 腾讯翻译
     *                     - TranslatorFactory::PLATFORM_ALI 阿里翻译
     *                     - TranslatorFactory::PLATFORM_VOLCENGINE 火山翻译
     *                     - TranslatorFactory::PLATFORM_MICROSOFT 微软翻译
     * @param array $config 配置数组，根据不同平台需要不同的参数：
     *                      - 百度/有道：['appId' => '...', 'key' => '...', 'options' => [...]]
     *                      - 谷歌/微软：['key' => '...', 'options' => [...]]
     *                      - 腾讯：['secretId' => '...', 'secretKey' => '...', 'options' => [...]]
     *                      - 阿里/火山：['accessKeyId' => '...', 'secretAccessKey' => '...', 'options' => [...]]
     * @return TranslatorInterface 翻译器实例
     * @throws \InvalidArgumentException 当翻译平台类型无效时抛出异常
     */
    public static function create($type, array $config = [])
    {
        switch (strtolower($type)) {
            case self::PLATFORM_BAIDU:
                return new BaiduTranslator(
                    isset($config['appId']) ? $config['appId'] : null,
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_GOOGLE:
                return new GoogleTranslator(
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_YOUDAO:
                return new YoudaoTranslator(
                    isset($config['appId']) ? $config['appId'] : null,
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_TENCENT:
                return new TencentTranslator(
                    isset($config['secretId']) ? $config['secretId'] : null,
                    isset($config['secretKey']) ? $config['secretKey'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_ALI:
                return new AliTranslator(
                    isset($config['accessKeyId']) ? $config['accessKeyId'] : null,
                    isset($config['accessKeySecret']) ? $config['accessKeySecret'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_VOLCENGINE:
                return new VolcengineTranslator(
                    isset($config['accessKeyId']) ? $config['accessKeyId'] : null,
                    isset($config['secretAccessKey']) ? $config['secretAccessKey'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case self::PLATFORM_MICROSOFT:
                return new MicrosoftTranslator(
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            default:
                throw new \InvalidArgumentException('无效的翻译平台类型: ' . $type);
        }
    }
}
