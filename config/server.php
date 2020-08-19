<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'url' => 'http://localhost:9999',
    'server' => \FastD\Swoole\Server\HTTPServer::class,
    'handle' => \FastD\Runtime\Swoole\Handle\HttpHandle::class,
    'options' => [
        'pid_file' => __DIR__ . '/../runtime/pid/' . app()->getName() . '.pid',
        'log_file' => __DIR__ . '/../runtime/logs/' . app()->getName() . '.pid',
        'log_level' => 5,
    ],
];
