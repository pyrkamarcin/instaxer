<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new \Instaxer\Request\Following($instaxer);
    $following = $following->getFollowing($account);

    $whiteList = new \Instaxer\Domain\WhiteList(__DIR__ . '/whitelist.dat');

    echo 'Current count: ' . count($following) . "\r\n";
    echo 'White list count: ' . $whiteList->count() . "\r\n";

    for ($c = 1; $c <= 20; $c++) {


        $profile = $following[random_int(0, count($following) - 1)];

        $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

        $userMostImportantStat = $user->getFollowerCount();

        if (!$whiteList->check($profile->getUserName())) {

            if ($userMostImportantStat < 50000) {
                echo $c . ": \t";
                $instaxer->instagram->unfollowUser($user);
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";

                sleep(random_int(3, 10));
            } else {

                echo $c . ": \t";
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ skip - too preaty ! ] ' . "\r\n";

                sleep(random_int(2, 6));
            }
        } else {
            echo $c . ": \t";
            echo $user->getUsername() . ' [ skip - whitelist member ] ' . "\r\n";
        }
    }


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
