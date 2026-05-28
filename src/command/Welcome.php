<?php

declare(strict_types=1);

namespace src\console;

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
        info('console log');
        $output->writeln('console: welcome fastd by console');
        return 0;
    }
}
