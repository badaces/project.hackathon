<?php

use CBC\Utility\Configuration;

mb_internal_encoding('UTF-8');

require 'di.php';
require 'routing.php';

/** @var Configuration $config */
$config = $di->get('config');
$isLocal = false;

switch ($_SERVER['SERVER_NAME']) {
    case 'localhost':
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $isLocal = true;
        break;
    default:
        break;
}

$config->set('app.local', $isLocal);
