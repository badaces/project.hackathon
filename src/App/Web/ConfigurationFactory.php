<?php

namespace App\Web;

use CBC\Utility\Configuration;

class ConfigurationFactory
{
    public static function create()
    {
        $configuration = new Configuration();

        $rootPath = realpath(__DIR__ . '/../../../');
        $configuration->set('root_path', $rootPath);

        $configPath = $rootPath . '/app/app-config.json';
        $configData = json_decode(file_get_contents($configPath), true);
        $configuration->setAll($configData);

        return $configuration;
    }
}
