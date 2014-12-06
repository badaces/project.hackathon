<?php

require '../vendor/autoload.php';
require '../config/config.php';

use App\Web\Application;

/** @var Application $app */
$app = $di->get(Application::class);
$app->run()->send();
