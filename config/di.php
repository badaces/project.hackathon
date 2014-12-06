<?php

use DCP\Di\Container;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$di = new Container();

$di
    ->register(Request::class, 'request')
    ->toFactory(function () {
        return Request::createFromGlobals();
    })
    ->asShared()
;

$di
    ->register(RequestContext::class)
    ->toFactory(function (Container $di) {
        return (new RequestContext())->fromRequest($di->get(Request::class));
    })
    ->asShared()
;

$di
    ->register(RouteCollection::class)
    ->toClass(RouteCollection::class)
    ->asShared()
;

$di
    ->register(UrlMatcherInterface::class, 'url_matcher')
    ->toClass(UrlMatcher::class)
    ->asShared()
;

$di
    ->register(Engine::class)
    ->toClass(Engine::class)
    ->addArgument('directory', realpath(__DIR__ . '/../templates'))
    ->asShared()
;
