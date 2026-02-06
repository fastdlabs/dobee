<?php

// Doc url: https://symfony.com/doc/current/components/cache.html

 return [
     // 文件类型缓存
     'php' => [
         'adapter' => [
             'class' => \Symfony\Component\Cache\Adapter\PhpFilesAdapter::class,
         ],
         'namespace' => '',
         'lifetime' => 3600,
         'directory' => '',
     ],
     'file' => [
         'adapter' => [
             'class' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
         ],
         'namespace' => '',
         'lifetime' => 3600,
         'directory' => __DIR__ . '/../runtime/cache/',
     ],
     // 中间件所需缓存
     'xmCache' => [
         'enable' => false,
         'adapter' => [
             'class' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
         ],
         'lifetime' => 60,
         'directory' => __DIR__ . '/../runtime/http/',
         'cache_keys' => ['foo',], // 会根据设置的 keys 列表进行缓存 key 处理
     ],
     // 动态类型缓存
     'redis' => [
         // adapter 配置针对连接器进行的配置
         'adapter' => [
             'class' => \Symfony\Component\Cache\Adapter\RedisAdapter::class,
             'dsn' => 'redis://%redis.pass%@%redis.host%:%redis.port%/%redis.db%',
             'options' => [
//                 'class' => null,
//                 'persistent' => 0,
//                 'persistent_id' => null,
//                 'timeout' => 30,
//                 'read_timeout' => 0,
//                 'retry_interval' => 0,
//                 'tcp_keepalive' => 0,
//                 'lazy' => null,
//                 'redis_cluster' => false,
//                 'redis_sentinel' => null,
//                 'dbindex' => 0,
//                 'failover' => 'none',
//                 'ssl' => null,
             ],
         ],
         // 这是针对 adapter 的配置
         'namespace' => '',
         'lifetime' => 3600,
         'marshaller' => null
     ],
     'memcache' => [
         'adapter' => [
             'class' => \Symfony\Component\Cache\Adapter\MemcachedAdapter::class,
             'dsn' => 'memcached://%mem.host%:%mem.port%',
             'options' => [
                 'libketama_compatible' => true,
                 'serializer' => 'igbinary',
             ],
         ],
         'namespace' => '',
         'lifetime' => 3600,
     ],
 ];
