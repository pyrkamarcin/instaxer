<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1, 10, 5);
    $instaxer->run(new \Instaxer\Model\ItemRepository($array));

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
