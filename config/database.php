<?php
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use App\src\Exceptions\Handler as HttpExceptionError;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->getDatabaseManager()->extend('mongodb', function($config, $name) {
    $config['name'] = $name;
    return new \Jenssegers\Mongodb\Connection($config);
});

$capsule->getContainer()->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    HttpExceptionError::class
);

$capsule->addConnection([
    'host'      => '127.0.0.1',
    'port'      => 27017,
    'database'  => 'zoox-test',
    'username'  => '',
    'password'  => '',
], 'mongodb');

$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();