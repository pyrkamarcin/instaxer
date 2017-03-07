<?php

namespace Monotype\Server;

use React\Datagram\Socket;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Command
 * @package Monotype\Server
 */
class Command
{
    /**
     * @var
     */
    public $inputOutput;
    /**
     * @var
     */
    public $client;
    /**
     * @var
     */
    public $command;

    /**
     * Command constructor.
     * @param SymfonyStyle $inputOutput
     * @param Socket $client
     * @param string $command
     */
    public function __construct(SymfonyStyle $inputOutput, Socket $client, string $command)
    {
        if (method_exists($this, $command)) {
            $this->{$command}($inputOutput, $client);
        } else {
            $inputOutput->warning('nie znaleziono funkcji');
        }
        $this->summary();
    }

    /**
     * @return bool
     */
    private function summary()
    {
        return true;
    }
}
