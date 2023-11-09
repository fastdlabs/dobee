<?php

 return [
     'file' => [
         'adapter' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
     ],
     'redis' => [
         'adapter' => \Symfony\Component\Cache\Adapter\RedisAdapter::class,
         'params' => [
             'dsn' => 'redis://127.0.0.1:6379/0',
         ]
     ],
     // middleware 配置
     'http' => [
         'adapter' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
         'params' => [
             'lifetime' => 60,
             'directory' => __DIR__ . '/../../runtime/cache/',
         ]
     ],
 ];
