<?php

// Swoole HTTP Server 基础配置。
//
// 默认只保留主应用端口；Demo 的 Stats / Swoole Listener 端口由
// fastd/dobee-demo 安装脚本写入下面的 demo 标记区。
$listens = [
    [
        'host' => '127.0.0.1',
        'port' => 9527,
        'worker' => \FastD\Listener\Server\SwHttpListener::class,
    ],
];

$demoListens = [];
// demo:swoole:start
// demo:swoole:end
$listens = array_merge($listens, $demoListens);

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
