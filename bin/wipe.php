<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/' . $array[$argv[1]]['username'] . '.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $userFeed = $instaxer->instagram->getUserFeed($account);

    foreach (array_reverse($userFeed->getItems()) as $item) {

        if ($item->getLikeCount() <= 100) {
            $instaxer->instagram->deleteMedia($item, $item->getMediaType());
            echo $item->getLikeCount() . ' ' . $item->getCommentCount();
            echo "\r\n";

            sleep(10);
        } else {
            echo 'skip: ' . $item->getLikeCount() . ' ' . $item->getCommentCount();
            echo "\r\n";
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
