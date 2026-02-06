<?php

// 应用引导文件，添加改文件的配置可以在 service register 的时候通过 Application::config 进行加载，否则只能通过 config() 手动加载
// config()->parse('路径')->get('文件名');
return [
    'name' => 'fastd8',

    'root' => __DIR__ . '/..',

    'timezone' => 'PRC',

    'log' => [
        'path' => __DIR__ . '/../runtime/logs',
        'level' => \Monolog\Level::Debug,
    ],

    'route'    => __DIR__ . '/../config/route.php',

    'service'  => __DIR__ . '/../config/service.php',

    'listener'  => __DIR__ . '/../config/listener.php',

    'database'  => __DIR__ . '//../config/database.php',

    'cache'     => __DIR__ . '/../config/cache.php',

    'swoole'    => __DIR__ . '/../config/swoole.php',

    'command'  => __DIR__ . '/../config/command.php',

    'process' => __DIR__ . '/../config/process.php',
];
