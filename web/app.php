<?php

require '../vendor/autoload.php';
require '../src/config/config.php';

use App\Web\Application;
use App\Web\API\Consumer\Wikipedia;

///** @var Application $app */
//$app = $di->get(Application::class);
//$app->run()->send();

/** @var Wikipedia $api */
$api = $di->get(Wikipedia::class);

$api->getArticleByName('Greenhouse effect');
