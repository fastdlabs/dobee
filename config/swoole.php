<?php

return [
    'listen' => [
        [
            'host' => '127.0.0.1',
            'port' => 9527,
            'worker' => \FastD\Listener\Server\SwHttpListener::class,
        ],
    ],
    'listener' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],
    'setting' => [
        'log_level' => 5,
        'enable_coroutine' => true,
        'http_compression' => false,
    ],
];
