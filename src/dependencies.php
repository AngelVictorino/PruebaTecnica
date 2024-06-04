<?php

use DI\ContainerBuilder;
use Slim\App;

return function (App $app) {
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions([
        'settings.displayErrorDetails' => true,
    ]);
    $container = $containerBuilder->build();

    $app->setContainer($container);

    $containerBuilder->addDefinitions(__DIR__ . '/repositories.php');
    $containerBuilder->addDefinitions(__DIR__ . '/services.php');
    $containerBuilder->addDefinitions(__DIR__ . '/middlewares.php');
    $containerBuilder->addDefinitions(__DIR__ . '/controllers.php');

    $dependencies = require __DIR__ . '/dependencies.php';
    $dependencies($app);
};
