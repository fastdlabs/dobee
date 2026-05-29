<?php

declare(strict_types=1);

namespace process;

use FastD\Swoole\Process\Worker;

class WelcomeWorker extends Worker
{
    public function process(Worker $worker): void
    {
        $env = config()->parsed->get('app.env', 'production');
        echo "Hello FastD [{$env}]\n";
    }
}
