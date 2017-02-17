<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Processor;


use FastD\Packet\Json;
use FastD\Swoole\Client\Sync\SyncClient;
use FastD\Swoole\Process;
use swoole_process;

class ServerProcessor extends Process
{
    public function handle(swoole_process $swoole_process)
    {
        $discoveries = config()->get('discovery');
        $ip = get_local_ip();

        timer_tick(1000, function () use ($discoveries, $ip) {
            $data = [
                'service'   => config()->get('name'),
                'pid'       => $this->server->getSwoole()->master_pid,
                'sock'      => $this->server->getServerType(),
                'host'      => $ip,
                'port'      => $this->server->getPort(),
                'error'     => $this->server->getSwoole()->getLastError(),
                'time'      => time()
            ];
            $data = array_merge($data, $this->server->getSwoole()->stats());
            $data = Json::encode($data);
            foreach ($discoveries as $server) {
                try {
                    $client = new SyncClient($server);
                    $client
                        ->connect(function ($client) use ($ip, $data) {
                            $client->send($data);
                        })
                        ->receive(function ($client, $data) {
                            print_r(Json::decode($data));
                            $client->close();
                        })
                        ->resolve()
                    ;
                } catch (\Exception $e) {
                    continue;
                }
            }
        });
    }
}