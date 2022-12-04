<?php


use Slim\Factory\AppFactory;

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

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

// Создаем Twig
$twig = Twig::create('templates', ['cache' => false]);

// Добавляем промежуточное ПО Twig-View
$app->add(TwigMiddleware::create($app, $twig));

$app->group('', include 'app/routes/root.php');

$app->run();
