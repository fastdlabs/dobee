<?php

// Swoole HTTP Server 基础配置。
//
// Demo 端口由 Demo 安装脚本生成的 config/swoole-demo.php 补充，
// 不会改写用户自定义的 swoole.php。
$servers = [
    'http' => [
        'host' => '127.0.0.1',
        'port' => 9527,
        'listener' => \FastD\Listener\Server\SwHttpListener::class,
    ],
];

$demoConfig = __DIR__ . '/swoole-demo.php';
if (is_file($demoConfig)) {
    $servers = array_merge($servers, require $demoConfig);
}

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
