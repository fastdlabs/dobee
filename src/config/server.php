<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'url' => 'http://127.0.0.1:9999',
    'server' => \FastD\Swoole\Server\HTTP::class, // 服务器
    'handle' => \FastD\Runtime\Swoole\Handler\HttpHandler::class, // 事件监听处理器
    // swoole server 配置项，与官网保持一致: https://wiki.swoole.com/#/server/setting
    'options' => [
        'log_file' => app()->getPath() . '/runtime/logs/' . app()->getName() . '.log', // 默认路径
        'log_level' => 5,
    ],
];
