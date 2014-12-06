<?php

namespace App\Web;

use CBC\Utility\Configuration;
use DCP\Di\Container;

class ConfigurationFactory
{
    public static function create(Container $container)
    {
        $rootPath = realpath(__DIR__ . '/../../../');
        $configPath = $rootPath . '/app-config.json';

        $configData = json_decode(file_get_contents($configPath), true);

        return new Configuration($configData);
    }
}
