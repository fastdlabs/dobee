<?php

declare(strict_types=1);

namespace terminal\console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Welcome extends Command
{
    public function configure(): void
    {
        $this->setName('welcome');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('console: welcome fastd by swoole');
        return 0;
    }
}
