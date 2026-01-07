<?php

return [
    'name' => 'dobee',

    'root' => __DIR__ . '/..',

    'timezone' => 'PRC',

    'log' => [
        'path' => __DIR__ . '/../runtime/logs',
        'level' => \Monolog\Level::Debug,
    ],

    'routes'    => __DIR__ . '/routes.php',

    'services'  => __DIR__ . '/services.php',

    'cache'     => __DIR__ . '/cache.php',

    'database'  => __DIR__ . '/database.php',

    'swoole'    => __DIR__ . '/swoole.php',

    'commands'  => __DIR__ . '/commands.php',

    'processes' => __DIR__ . '/processes.php',
];
