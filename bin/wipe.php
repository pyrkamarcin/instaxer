<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $userFeed = $instaxer->instagram->getUserFeed($account);

    foreach ($userFeed->getItems() as $item) {
        $instaxer->instagram->deleteMedia($item, $item->getMediaType());
        echo $item->getCaption()->getText();
        echo "\r\n";
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
