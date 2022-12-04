<?php

return [

    // Подключение к БД
    'db' => function ($container) {
        return new \Model\Connect($container->get('settings')['db']);
    },

    'pagination' => function ($container) {
        return new \Model\Pagination($container);
    }
];