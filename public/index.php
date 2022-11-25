<?php

use Slim\Factory\AppFactory;

chdir(__DIR__ . '/../');

// Подключаем autoload
require 'vendor/autoload.php';

// Создаем экземпляр контейнера
$containerBuilder = new \DI\ContainerBuilder();

$containerBuilder->addDefinitions(
    'app/dependencies.php',
    'app/settings.php',
);

$container = $containerBuilder->build();

// Передаем контейнер в приложение
AppFactory::setContainer($container);

// Создаем приложение
$app = AppFactory::create();

$app->group('', include 'app/routes/root.php');

$app->run();
