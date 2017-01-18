<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$instaxer = new Application();

$instaxer->add(new \Instaxer\Command\TestCommand());

$instaxer->run();
