<?php
return function ($app)
{
    // Маршрут для отображения "Отправить данные"
    $app->map(['*'], '[/]', \Controllers\Sensor\GetController::class);

    // Маршрут для добавления новых данных
    $app->map(['*'], '/add[/]', \Controllers\Sensor\AddController::class);

    // Маршрут для "Показать данные"
    $app->map(['*'], '/show[/]', \Controllers\Sensor\ShowController::class);

};