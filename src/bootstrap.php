<?php

// 应用引导文件，添加改文件的配置可以在 service register 的时候通过 Application::config 进行加载，否则只能通过 config() 手动加载
// config()->parse('路径')->get('文件名');
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
