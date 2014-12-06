<?php

require '../vendor/autoload.php';
require '../config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use App\Web\Action\ActionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/** @var Request $request */
$request = $di->get('request');

/** @var UrlMatcherInterface $matcher */
$matcher = $di->get('url_matcher');

try {
    // @TODO: Create an application class to handle this.
    $route = $matcher->match($request->getRequestUri());
    $action = sprintf('App\Web\Action\%sAction', $route['controller']);

    /** @var ActionInterface $controller */
    $controller = $di->get($action);

    $responder = $controller->execute();
    $response = $responder->execute();
    $response->send();
} catch (ResourceNotFoundException $e) {
    $response = new Response(':-( not found.', Response::HTTP_NOT_FOUND);
    $response->send();
}