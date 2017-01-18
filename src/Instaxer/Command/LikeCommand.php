<?php

namespace Instaxer\Command;

use Instaxer\Configuration;
use Instaxer\DatabaseConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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
        $value = Yaml::parse(file_get_contents(__DIR__ . '/../../../config/config.yml'));


        dump($value);


//        try {
//
//            $instaxer = new Instaxer($user1, $pass1, 10, 10);
//            $instaxer->run(new ItemRepository($array));
//
//        } catch (\Exception $e) {
//            echo $e->getMessage() . "\n";
//        }
    }
}
