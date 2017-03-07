<?php

namespace Monotype\Bundle\TransportLayerBundle\Command;

use React\Datagram;
use React\Dns\Resolver;
use React\EventLoop;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ServerCommandCommand
 * @package Monotype\Bundle\TransportLayerBundle\Command
 */
class ServerCommandCommand extends ContainerAwareCommand
{
    /**
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('server:command')
            ->setDescription('Send command to local server')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $argument = $input->getArgument('argument');

        $loop = EventLoop\Factory::create();
        $factory = new Resolver\Factory();

        $resolver = $factory->createCached('8.8.8.8', $loop);
        $factory = new Datagram\Factory($loop, $resolver);

        $factory->createClient('127.0.0.1:4000')->then(function (Datagram\Socket $client) use ($argument) {
            $client->send($argument);
            $client->end();
        }, function ($error) use ($inputOutput) {
            $inputOutput->error('ERROR: ' . $error->getMessage());
        });

        $loop->run();
    }
}
