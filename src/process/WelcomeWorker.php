<?php

declare(strict_types=1);

namespace process;

use FastD\Swoole\Process\Worker;

class WelcomeWorker extends Worker
{
    public function process(Worker $worker): void
    {
        echo "Hello FastD\n";
    }
}
