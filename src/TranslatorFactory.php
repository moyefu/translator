<?php

namespace Moyefu;

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
     * 创建翻译器实例
     *
     * @param string $type 翻译平台类型，使用常量：
     *                     - TranslatorFactory::PLATFORM_BAIDU  百度翻译
     *                     - TranslatorFactory::PLATFORM_GOOGLE 谷歌翻译
     *                     - TranslatorFactory::PLATFORM_YOUDAO 有道翻译
     * @param array $config 配置数组，根据不同平台需要不同的参数：
     *                      - 百度/有道：['appId' => '...', 'key' => '...', 'options' => [...]]
     *                      - 谷歌：['key' => '...', 'options' => [...]]
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
            default:
                throw new \InvalidArgumentException('无效的翻译平台类型: ' . $type);
        }
    }
}
