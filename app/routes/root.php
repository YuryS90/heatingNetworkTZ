<?php

return function ($app)
{
    // Маршрут для отображения главной страницы
    $app->map(['*'], '/', \Controllers\Home\HomeController::class);

    // Группа маршрутов...
    $app->group('/sensor', include 'app\routes\sensor\sensor.php');

};