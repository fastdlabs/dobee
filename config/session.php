<?php

// 会话配置：由 FastD\ServiceProvider\SessionServiceProvider 读取。
// handler=auto 时，Swoole 运行时使用共享内存 Table，其余运行时使用文件存储。
return [
    'enabled' => true,
    'handler' => 'auto',
    'ttl' => 1440,
    'cookie' => [
        'name' => 'FASTD_SESSID',
        'path' => '/',
        'domain' => '',
        'secure' => false,      // 生产环境（HTTPS）必须改为 true
        'http_only' => true,
        'same_site' => 'Lax',
        'lifetime' => 0,
    ],
    'file' => [
        'path' => __DIR__ . '/../runtime/session',
    ],
    'swoole_table' => [
        'size' => 2048,         // 有效会话数约为 0.73 * size
        'max_data_size' => 4096,
    ],
    'gc_probability' => 100,    // 1/100 请求触发一次过期文件清理
];
