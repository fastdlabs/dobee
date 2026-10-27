<?php

return [
    'servers' => [
        'http' => [
            'host' => '127.0.0.1',
            'port' => 9527,
            'listener' => \FastD\Listener\Server\SwHttpListener::class,
        ],
    ],

    'listeners' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],

    'options' => [
        'log_level' => 5,
        'enable_coroutine' => true,
        'http_compression' => false,
    ],
];
