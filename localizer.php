<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1, 10, 10);
    $instaxer->localizer(new \Instaxer\Domain\Model\ItemRepository($locales));

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
