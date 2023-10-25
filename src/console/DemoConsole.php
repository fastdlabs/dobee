<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoConsole extends Command
{
    public function configure(): void
    {
        $this->setName('demo');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('hello world');
        return 0;
    }
}
