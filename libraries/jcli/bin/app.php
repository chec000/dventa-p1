<?php
/**
 * @TO-DO quitar esta linea
 */
//error_reporting(0);
// quitar hasta aqui

use Zend\Console\Console;
use ZF\Console\Application;
use ZF\Console\Dispatcher;
use Adteam\Core\Motivale\Component;

chdir(realpath(__DIR__.'/../'));

include 'vendor/autoload.php';

$application = Zend\Mvc\Application::init(require 'config/application.config.php');
$services    = $application->getServiceManager();
$dispatcher = new Dispatcher();

$dispatcher->map('motivale', function ($route, $console) use ($services) {
    new Component($services);
});

$appconsole = new Application(
    "Proceso para actualizar catalogos motivale",
    "1.0.2",
    include __DIR__.'/../config/console.config.php',
    Console::getInstance(),
    $dispatcher
);

$exit = $appconsole->run();

exit($exit);