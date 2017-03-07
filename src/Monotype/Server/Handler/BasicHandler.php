<?php

namespace Monotype\Server\Handler;

use Monotype\Domain\Model\Path;
use Monotype\Server\Handler;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class BasicHandler
 * @package Monotype\Server\Handler
 */
class BasicHandler extends Handler
{
    /**
     *
     */
    public function createHandler()
    {
        $session = new Session();
        $actualTimestamp = microtime($get_as_float = true);
        $path = new Path(['location' => __DIR__ . '/../../../../var/temp/stock']);

        if ($actualTimestamp - $session->get('timestamp') > 2) {

            $name = tempnam($path->getLocation(), sha1($this->serverAddress) . '_');
            $session->set('tempname', $name);
            file_put_contents($name, $this->message, FILE_APPEND);
            $session->set('timestamp', $actualTimestamp);

            $this->io->block('');
            $this->io->writeln('Get data from: ' . $this->serverAddress);

            $dateTime = new \DateTime('now');
            $this->io->writeln('Date: ' . $dateTime->format('d/m/Y H:i:s'));

            $header = StringOperators::getTwoFirstLines($this->message);

            if ($header) {
                $fileName = StringOperators::getFileName($header[0]);
                $session->set('fileName', $fileName);

                $this->io->writeln('Find filename: ' . $fileName);

                $pathName = StringOperators::getPath($header[1]);
                $session->set('pathName', $pathName);

                $this->io->writeln('Find path: ' . $pathName);
            }
            $this->io->write('Create file: .');

        } elseif (strlen($this->message) < 128 || ($actualTimestamp - $session->get('timestamp') > 0.7 & $actualTimestamp - $session->get('timestamp') <= 2)) {
            $session->set('timestamp', $actualTimestamp);
            file_put_contents($session->get('tempname'), $this->message, FILE_APPEND);
            $this->io->writeln('. (end)');

            $this->io->writeln('Temp: ' . $session->get('tempname'));
            $this->io->writeln('Path: ' . $session->get('pathName'));
            $this->io->writeln('File: ' . $session->get('fileName'));

            $session->remove('fileName');
            $session->remove('pathName');
        } else {
            $session->set('timestamp', $actualTimestamp);
            file_put_contents($session->get('tempname'), $this->message, FILE_APPEND);
            $this->io->write('.');
        }
    }
}
