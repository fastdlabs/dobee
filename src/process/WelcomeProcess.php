<?php

declare(strict_types=1);

namespace terminal\process;

use FastD\Swoole\Process\Worker;

class WelcomeProcess extends Worker
{
    public function process(Worker $worker): void
    {
        info('process log');
        echo 'process: welcome fastd by process' . PHP_EOL;
    }
}
