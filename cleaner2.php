<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();
    $following = $instaxer->getFollowing($account);

    echo 'Current count: ' . count($following) . "\r\n";

    for ($c = 1; $c <= 200; $c++) {

        echo $c . ": \t";

        $profile = $following[random_int(0, count($following) - 1)];

        $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

        $userMostImportantStat = $user->getFollowerCount();

        if ($userMostImportantStat < 2000) {
            $instaxer->instagram->unfollowUser($user);
            echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";
            sleep(10);
        } else {
            echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ stay ] ' . "\r\n";
        }

        sleep(2);

    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
