<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/** @var RouteCollection $routes */
$routes = $di->get(RouteCollection::class);

$routes->add('home', new Route('/', ['controller' => 'Home']));