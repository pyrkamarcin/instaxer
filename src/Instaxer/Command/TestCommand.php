<?php

namespace Instaxer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 * @package Instaxer\Command
 */
class TestCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('test:run')
            ->setDescription('Test command.')
            ->setHelp("This command do not anything.");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Test command',
            '============',
            '',
        ]);

        $output->writeln('Test!');
    }
}
