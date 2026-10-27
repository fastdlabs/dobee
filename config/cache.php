<?php

// 缓存配置：由 FastD\Cache\ServiceProvider\CacheServiceProvider 读取。
// 文档：https://symfony.com/doc/current/components/cache.html
return [
    // 普通文件缓存池（Demo 的 /cache-demo 使用此池）
    'file' => [
        'adapter' => [
            'class' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
        ],
        'namespace' => '',
        'lifetime' => 3600,
        'directory' => __DIR__ . '/../runtime/cache/',
    ],

    // HTTP 缓存中间件配置（默认关闭，确认路由无状态后再开启）
    'xmCache' => [
        'enable' => false,
        'adapter' => [
            'class' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
        ],
        'lifetime' => 60,
        'directory' => __DIR__ . '/../runtime/cache/http/',
        'cache_keys' => ['foo'],
    ],

    // PHP 文件缓存示例
    'php' => [
        'adapter' => [
            'class' => \Symfony\Component\Cache\Adapter\PhpFilesAdapter::class,
        ],
        'namespace' => '',
        'lifetime' => 3600,
        'directory' => __DIR__ . '/../runtime/cache/php/',
    ],

    // Redis 示例（需要 redis 扩展/服务，按需打开）
    // 'redis' => [
    //     'adapter' => [
    //         'class' => \Symfony\Component\Cache\Adapter\RedisAdapter::class,
    //         'dsn' => 'redis://%redis.pass%@%redis.host%:%redis.port%/%redis.db%',
    //         'options' => [],
    //     ],
    //     'namespace' => '',
    //     'lifetime' => 3600,
    // ],

    // Memcached 示例（需要 memcached 扩展/服务，按需打开）
    // 'memcache' => [
    //     'adapter' => [
    //         'class' => \Symfony\Component\Cache\Adapter\MemcachedAdapter::class,
    //         'dsn' => 'memcached://%mem.host%:%mem.port%',
    //     ],
    //     'namespace' => '',
    //     'lifetime' => 3600,
    // ],
];
