<?php

namespace App\Storage;

use CBC\Utility\Configuration;
use DCP\Di\Container;

class PdoConnectionFactory
{
    public static function create(Container $container)
    {
        /** @var Configuration $configuration */
        $configuration = $container->get('config');
        $dbConfig = $configuration->get('database');

        $dsn = sprintf('%s:host=%s;dbname=%s', $dbConfig['adapter'], $dbConfig['host'], $dbConfig['dbname']);

        return new \PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    }
}
