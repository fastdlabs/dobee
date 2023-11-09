<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

use FastD\Swoole\Server\HTTP;
use FastD\Server\Handler\HttpHandler;

return [
    'host' => 'http://127.0.0.1:9999',
    'handle' => HttpHandler::class, // 事件监听处理器
    // swoole server 配置项，与官网保持一致: https://wiki.swoole.com/#/server/setting
    'options' => [
        'log_file' => app()->getPath() . '/runtime/logs/' . app()->getName() . '.log', // 默认路径
        'log_level' => 5,
    ],
];
