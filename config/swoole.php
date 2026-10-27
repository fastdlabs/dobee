<?php

// Swoole HTTP Server 配置。
$listens = [
    // 主应用端口：交给 FastD 核心 RequestListener 分发到 Application
    [
        'host' => '127.0.0.1',
        'port' => 9527,
        'worker' => \FastD\Listener\Server\SwHttpListener::class,
    ],
    // 内置统计端口：http://127.0.0.1:9528/
    [
        'host' => '127.0.0.1',
        'port' => 9528,
        'worker' => \FastD\Swoole\Listener\Server\StatsListener::class,
    ],
];

// Demo 包的独立 Swoole Listener 示例：http://127.0.0.1:9529/
if (class_exists(\FastD\Demo\Listener\Server\DemoServerListener::class)) {
    $listens[] = [
        'host' => '127.0.0.1',
        'port' => 9529,
        'worker' => \FastD\Demo\Listener\Server\DemoServerListener::class,
    ];
}

return [
    'listen' => $listens,

    // Swoole 服务进程事件监听
    'listener' => [
        \FastD\Swoole\Listener\Server\WorkerListener::class,
    ],

    // 与 Swoole 官网保持一致：https://wiki.swoole.com/#/server/setting
    'setting' => [
        'log_level' => 5,
        // SSE 需要协程 write()
        'enable_coroutine' => true,
        // SSE 需要关闭 HTTP 压缩，避免分块输出被压缩缓冲
        'http_compression' => false,
        // 可按需增加 worker_num / max_request / task_worker_num 等
    ],
];
