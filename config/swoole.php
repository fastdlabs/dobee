<?php

// Swoole HTTP Server 基础配置。
//
// Demo 端口由 fastd/dobee-demo 安装脚本在安装时补充。
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
