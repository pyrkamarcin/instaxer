<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/' . $array[$argv[1]]['username'] . '.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[$argv[1]]['username'], $array[$argv[1]]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $followers = new \Instaxer\Request\Followers($instaxer);
    $followers = $followers->getFollowers($account);

    $whiteList = new \Instaxer\Domain\WhiteList(__DIR__ . '/../whitelist.dat');

    echo 'Current count: ' . count($followers) . "\r\n";
    echo 'White list count: ' . $whiteList->count() . "\r\n";

    for ($c = 0; $c <= 200; $c++) {

        $profile = $followers[$c];

        $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

        $userMostImportantStat = $user->getFollowerCount();

        if (!$whiteList->check($profile->getUserName())) {

            if ($userMostImportantStat < 100000) {
                echo $c . ": \t";
                $instaxer->instagram->unfollowUser($user);
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";

                sleep(random_int(1, 2));
            } else {

                echo $c . ": \t";
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ skip - too preaty ! ] ' . "\r\n";

                sleep(random_int(1, 2));
            }
        } else {
            echo $c . ": \t";
            echo $user->getUsername() . ' [ skip - whitelist member ] ' . "\r\n";
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
