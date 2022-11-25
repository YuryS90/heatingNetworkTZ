<?php

return [

    // Подключение к БД
    'db' => function ($container) {
        return new \Model\Connect($container);
    },

    // Подключение шаблонизатора
    'twig' => function ($container) {
        return new \Twig\Environment($container->get('settings')['loader']);
    },

];