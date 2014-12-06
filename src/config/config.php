<?php

require 'di.php';
require 'routing.php';

switch ($_SERVER['SERVER_NAME']) {
    case 'localhost':
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        break;
    default:
        break;
}
