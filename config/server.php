<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'host' => 'http://'.get_local_ip().':9527',
    'class' => \Server\TaskServer::class,
    'options' => [
        'user' => 'nobody',
        'group' => 'nogroup',
        'pid_file' => __DIR__ . '/../runtime/pid/' . app()->getName() . '.pid',
        'log_file' => __DIR__ . '/../runtime/logs/' . app()->getName() . '.pid',
        'log_level' => 5,
        'worker_num' => 10,
        'task_worker_num' => 20,
    ],
    'processes' => [

    ],
    'listeners' => [
        [
            'class' => \FastD\Servitization\Server\TCPServer::class,
            'host' => 'tcp://'.get_local_ip().':9528',
        ]
    ],
];