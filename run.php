<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1, 150, 4);
    $instaxer->run($array);

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
