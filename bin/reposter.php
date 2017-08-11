<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $userName = $argv[1];

    $account = $instaxer->instagram->getUserByUsername($userName);
    $userFeed = $instaxer->instagram->getUserFeed($account);

    $sumArray = 0;

    foreach ($userFeed->getItems() as $item) {
        $sumArray += $item->getLikeCount();
    }

    $avrg = $sumArray / count($userFeed->getItems());

    foreach ($userFeed->getItems() as $item) {

        if ($item->getLikeCount() > $avrg * 1.2) {

            $image = $item->getImageVersions2()->getCandidates();
            $downloader = new \Instaxer\Downloader();
            $downloader->drain($image[0]->getUrl());
            $requestPublishPhoto = new Instaxer\Request\PublishPhoto($instaxer);

            $response = $requestPublishPhoto
                ->pull(
                    __DIR__ . '/../app/storage/test.jpg', ''

                );

            $editResponse = $instaxer
                ->instagram
                ->editMedia(
                    $response->getMedia()->getId(),
                    '#portrait #beauty #portrait_perfection #mood #excellent_portraits #portraitpage #excellent_portraits #love #moodportrait #simple #bw #bwmasters #bwphoto #fitnessapparel #fitnessfun #fitnessforlife #fitnessguru #fitnessphysique #fitnesslover #fitnesstips #fitnessworld #fitnessfreaks #fitnesstime #fitnesslove #fitnessaddicted #fitnesstrainer #fitnesschick '
                );
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
