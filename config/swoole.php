<?php

// Swoole HTTP Server 基础配置。
//
// 可在 $servers 中追加自定义监听端口；demo 只维护 marker 区块。
$servers = [
    'http' => [
        'host' => '127.0.0.1',
        'port' => 9527,
        'listener' => \FastD\Listener\Server\SwHttpListener::class,
    ],
];

// demo:swoole:start
// demo:swoole:end

return [
    'servers' => $servers,

    'listeners' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],

    'options' => [
        'log_level' => 5,
        'enable_coroutine' => true,
        'http_compression' => false,
    ],
];
