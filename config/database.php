<?php

// 数据库配置：由 FastD\MedooDB\ServiceProvider\DatabaseServiceProvider 读取。
// Demo 默认使用 SQLite，无需外部数据库；生产环境可切换 MySQL/PostgreSQL。
return [
    'default' => [
        'type' => 'sqlite',
        'database' => __DIR__ . '/../runtime/demo.sqlite',
    ],

    // MySQL 示例：
    // 'default' => [
    //     'type' => 'mysql',
    //     'host' => '127.0.0.1',
    //     'database' => 'dobee',
    //     'username' => 'root',
    //     'password' => '',
    //     'charset' => 'utf8mb4',
    //     'port' => 3306,
    // ],

    // PostgreSQL 示例：
    // 'default' => [
    //     'type' => 'pgsql',
    //     'host' => '127.0.0.1',
    //     'database' => 'dobee',
    //     'username' => 'postgres',
    //     'password' => '',
    //     'port' => 5432,
    // ],
];
