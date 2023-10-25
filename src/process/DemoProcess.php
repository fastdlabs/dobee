<?php


namespace process;


use FastD\Swoole\Process\Process;

class DemoProcess extends Process
{
    public function handle(): void
    {
        echo 'run process';
    }

    public function exit(int $pid, int $code, int $signal): void
    {
        print_r(func_get_args());
    }
}
