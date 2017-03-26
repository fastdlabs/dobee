<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Server;


use FastD\Servitization\Server\HTTPServer;
use swoole_server;

class TaskServer extends HTTPServer
{
    public function doTask(swoole_server $server, $data, $taskId, $workerId)
    {
        echo $data . PHP_EOL;
    }
}