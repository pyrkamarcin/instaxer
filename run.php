<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);
    $instaxer->counter = 50;
    $instaxer->long = 20;
    $instaxer->run(new \Instaxer\Domain\Model\ItemRepository($array));

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
