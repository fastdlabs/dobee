<?php

return [
    'listen' => [
        [
            'host' => '127.0.0.1',
            'port' => 9527,
            'worker' => \listener\SwRequestListener::class,
        ],
    ],
    'worker' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],
    // swoole server 配置项，与官网保持一致: https://wiki.swoole.com/#/server/setting
    'setting' => [
        'log_level' => 5,
    ],
];
