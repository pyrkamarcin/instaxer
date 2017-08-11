<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $profile = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new \Instaxer\Request\Following($instaxer);
    $followers = new \Instaxer\Request\Followers($instaxer);

    $following = $following->getFollowing($profile);
    $followers = $followers->getFollowers($profile);

    foreach ($following as $account) {

        $userFeed = $instaxer->instagram->getUserFeed($account);

        foreach ($userFeed->getItems() as $item) {

            if ($item->getLikeCount()) {

                $image = $item->getImageVersions2()->getCandidates();
                $downloader = new \Instaxer\Downloader();
                $downloader->drain($image[0]->getUrl());

                echo '.';
                sleep(random_int(1, 2));
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
