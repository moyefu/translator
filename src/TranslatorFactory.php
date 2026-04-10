<?php

namespace Moyefu;

class TranslatorFactory
{
    /**
     * Create a translator instance
     *
     * @param string $type
     * @param array $config
     * @return TranslatorInterface
     */
    public static function create($type, array $config = [])
    {
        switch (strtolower($type)) {
            case 'baidu':
                return new BaiduTranslator(
                    isset($config['appId']) ? $config['appId'] : null,
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case 'google':
                return new GoogleTranslator(
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            case 'youdao':
                return new YoudaoTranslator(
                    isset($config['appId']) ? $config['appId'] : null,
                    isset($config['key']) ? $config['key'] : null,
                    isset($config['options']) ? $config['options'] : []
                );
            default:
                throw new \InvalidArgumentException('Invalid translator type: ' . $type);
        }
    }
}
