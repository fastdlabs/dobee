<?php

// 会话配置：由 FastD\ServiceProvider\SessionServiceProvider 读取。
// handler=auto：Swoole 使用共享内存 Table，FastCGI 使用文件。
return [
    'enabled' => true,
    'handler' => 'auto', // auto | swoole_table | native_file
    'ttl' => 1440,
    'cookie' => [
        'name' => 'FASTD_SESSID',
        'path' => '/',
        'domain' => '',
        'secure' => false,      // HTTPS 环境务必改为 true
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
    'gc_probability' => 100,    // 1/100 请求触发一次过期清理
];
