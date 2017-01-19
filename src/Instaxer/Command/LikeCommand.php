<?php

namespace Instaxer\Command;

use Instaxer\Domain\Model\ItemRepository;
use Instaxer\Instaxer;
use Noodlehaus\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LikeCommand extends Command
{
    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('like')
            ->setDescription('')
            ->setHelp('');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conf = new Config(__DIR__ . '/../../../config/config.json');
        $tags = explode("\n", file_get_contents(__DIR__ . '/../../../app/storage/tags.dat'));

        try {

            $instaxer = new Instaxer($conf->get('username'), $conf->get('password'), 10, 10);
            $instaxer->run(new ItemRepository($tags));

        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }
}
