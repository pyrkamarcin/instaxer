<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($user1, $pass1);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new \Instaxer\Request\Following($instaxer);
    $following = $following->getFollowing($account);

    $whiteList = new \Instaxer\Domain\WhiteList(__DIR__ . '/whitelist.dat');

    echo 'Current count: ' . count($following) . "\r\n";
    echo 'White list count: ' . $whiteList->count() . "\r\n";

    for ($c = 1; $c <= 200; $c++) {


        $profile = $following[random_int(0, count($following) - 1)];

        $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

        $userMostImportantStat = $user->getFollowerCount();

        if (!$whiteList->check($profile->getUserName())) {

            if ($userMostImportantStat < 200) {
                echo $c . ": \t";
                $instaxer->instagram->unfollowUser($user);
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";
                sleep(random_int(3, 7));
            } else {

                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ skip - too preaty ! ] ' . "\r\n";

//            echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ stay ] ';
//            $hashTagFeed = $instaxer->instagram->getUserFeed($user);
//            $items = array_slice($hashTagFeed->getItems(), 0, random_int(1, 6));
//            foreach ($items as $hashTagFeedItem) {
//                $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
//                echo sprintf('[ liked ] ');
//                sleep(random_int(3, 7));
//            }
//            echo "\r\n";
            }
        } else {
            echo $user->getUsername() . ' [ skip - whitelist member ] ' . "\r\n";
        }
    }


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
