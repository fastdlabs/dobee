<?php

// 应用引导文件：保持最小骨架，Demo 能力由 fastd/dobee-demo 按需提供。
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

    'swoole' => __DIR__ . '/../config/swoole.php',
];
