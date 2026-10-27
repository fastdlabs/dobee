<?php

// 应用引导文件：配置项按需保留，Demo 由 fastd/dobee-demo 可选提供。
return [
    'name' => 'fastd8',

    'root' => __DIR__ . '/..',

    'timezone' => 'Asia/Shanghai',

    'log' => [
        'path' => __DIR__ . '/../runtime/logs',
        'level' => \Monolog\Level::Debug,
    ],

    'route' => __DIR__ . '/../routes/web.php',

    'service' => __DIR__ . '/../config/service.php',

    'listener' => __DIR__ . '/../config/listener.php',

    'cache' => __DIR__ . '/../config/cache.php',
    'database' => __DIR__ . '/../config/database.php',
    'session' => __DIR__ . '/../config/session.php',
    'command' => __DIR__ . '/../config/command.php',
    'process' => __DIR__ . '/../config/process.php',
    'swoole' => __DIR__ . '/../config/swoole.php',
];
