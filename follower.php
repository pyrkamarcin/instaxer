<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    return new \Instaxer\Instaxer($user1, $pass1)->counter;

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
