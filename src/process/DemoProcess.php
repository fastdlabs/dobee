<?php

namespace process;

use FastD\Swoole\Process\AbstractProcess;

class DemoProcess extends AbstractProcess
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
