<?php

declare(strict_types=1);

namespace terminal\process;

use FastD\Swoole\Process\AbstractProcess;

class WelcomeProcess extends AbstractProcess
{
    public function handle(): void
    {
        echo 'process: welcome fastd by swoole';
    }

    public function exit(int $pid, int $code, int $signal): void
    {
        echo 'exit welcome process';
    }
}
