<?php

declare(strict_types=1);

namespace command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WelcomeCommand extends Command
{
    public function configure(): void
    {
        $this->setName('welcome');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello FastD and goodbye FastD [' . container()->getRuntime() . ']');
        
        return 0;
    }
}
