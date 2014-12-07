<?php

use Symfony\Component\Console\Application;

$_SERVER['SERVER_NAME'] = 'localhost';

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config/config.php';

/** @var Application $console */
$console = $di->get(Application::class);
$console->run();
