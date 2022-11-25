<?php

return [
    'settings' => [

        // Настройки подключения к БД
        'db' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'database' => 'water'
        ],

        // Указываем, где Loader'у искать twig-шаблоны (из документации)
        'loader' => function () {
            return new \Twig\Loader\FilesystemLoader('templates');
        },
    ]
];