<?php

use App\Command\ImportTemperatureDataCommand;
use App\Command\ImportMethaneDataCommand;
use App\Command\ImportCo2DataCommand;
use App\Entity\Repository\DataPointRepository;
use App\Entity\Repository\DataPointTypeRepository;
use App\Storage\Mysql\DataPointMysqlRepository;
use App\Storage\Mysql\DataPointTypeMysqlRepository;
use App\Storage\PdoConnectionFactory;
use App\Web\Plates\Extension\AssetResolverExtension;
use App\Web\ConfigurationFactory;
use CBC\Utility\Configuration;
use DCP\Di\Container;
use DCP\Di\ServiceReference;
use League\Plates\Engine;
use Symfony\Component\Console\Application;
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
    ->addMethodCall('loadExtension', [new ServiceReference(AssetResolverExtension::class)])
    ->asShared()
;

$di
    ->register(Configuration::class, 'config')
    ->toFactory([ConfigurationFactory::class, 'create'])
    ->asShared()
;

$di
    ->register(Application::class)
    ->toClass(Application::class)
    ->addMethodCall('add', [new ServiceReference(ImportTemperatureDataCommand::class)])
    ->addMethodCall('add', [new ServiceReference(ImportMethaneDataCommand::class)])
    ->addMethodCall('add', [new ServiceReference(ImportCo2DataCommand::class)])
    ->asShared()
;

$di
    ->register(DataPointRepository::class)
    ->toClass(DataPointMysqlRepository::class)
;

$di
    ->register(DataPointTypeRepository::class)
    ->toClass(DataPointTypeMysqlRepository::class)
;

$di
    ->register(\PDO::class)
    ->toFactory([PdoConnectionFactory::class, 'create'])
    ->asShared()
;
