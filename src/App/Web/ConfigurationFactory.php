<?php

namespace App\Web;

use CBC\Utility\Configuration;

class ConfigurationFactory
{
    public static function create()
    {
        $rootPath = realpath(__DIR__ . '/../../../');
        $configPath = $rootPath . '/app-config.json';

        $configData = json_decode(file_get_contents($configPath), true);

        return new Configuration($configData);
    }
}
