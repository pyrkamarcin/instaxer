<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $userName = 'weronikasochacz';

    $account = $instaxer->instagram->getUserByUsername($userName);
    $userFeed = $instaxer->instagram->getUserFeed($account);

    $sumArray = 0;

    foreach ($userFeed->getItems() as $item) {
        $sumArray += $item->getLikeCount();
    }

    $avrg = $sumArray / count($userFeed->getItems());

    foreach ($userFeed->getItems() as $item) {

        dump($item->getLikeCount());

        if ($item->getLikeCount() > $avrg * 0.8) {

            $image = $item->getImageVersions2()->getCandidates();
            $downloader = new \Instaxer\Downloader();
            $downloader->drain($image[0]->getUrl());
            $requestPublishPhoto = new Instaxer\Request\PublishPhoto($instaxer);

            dump($requestPublishPhoto->pull(
                __DIR__ . '/../app/storage/test.jpg',
                'Repost from: @' . $userName . '. ' . "\r\n" .
                $item->getCaption()->getText())
            );

            sleep(random_int(5, 15));
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
