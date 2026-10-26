<?php

return [
    'listen' => [
        [
            'host' => '127.0.0.1',
            'port' => 9527,
            'worker' => \Listener\Server\SwRequestListener::class,
        ],
        [
            'host' => '127.0.0.1',
            'port' => 9528,
            'worker' => \FastD\Swoole\Listener\Server\StatsListener::class,
        ],
    ],
    // swoole 服务进程事件监听
    'listener' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],
    // swoole server 配置项，与官网保持一致: https://wiki.swoole.com/#/server/setting
    'setting' => [
        'log_level' => 5,
        // SSE 必需：write() 在协程中执行
        'enable_coroutine' => true,
        // SSE 必需：关闭 HTTP 压缩，避免分块输出被压缩缓冲
        'http_compression' => false,
    ],
];
