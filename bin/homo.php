<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/' . $array[$argv[1]]['username'] . '.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[$argv[1]]['username'], $array[$argv[1]]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $userFeed = $instaxer->instagram->getUserFeed($account);

    foreach ($userFeed->getItems() as $item) {

        echo $item->getLikeCount() . ' ' . $item->getCommentCount();

        $instaxer->instagram->editMedia($item->getId(), '#portrait #beauty #portrait_perfection #mood #excellent_portraits #portraitpage #excellent_portraits #love #moodportrait #simple #bw #bwmasters #bwphoto #fitnessapparel #fitnessfun #fitnessforlife #fitnessguru #fitnessphysique #fitnesslover #fitnesstips #fitnessworld #fitnessfreaks #fitnesstime #fitnesslove #fitnessaddicted #fitnesstrainer #fitnesschick ');

        echo "\r\n";
        sleep(10);
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
