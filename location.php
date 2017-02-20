<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);

    $locations = $instaxer->instagram->searchFacebookPlacesByLocation(52.408, 16.933);

    foreach ($locations->getItems() as $location) {

        $items = $instaxer->instagram->getLocationFeed($location->getLocation());

        echo sprintf('#%s: ' . "\r\n", $location->getTitle());

        foreach ($items->getItems() as $hashTagFeedItem) {

            $id = $hashTagFeedItem->getId();
            $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
            $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

            echo sprintf('User: %s; ', $user->getUsername());
            echo sprintf('id: %s,  ', $id);
            echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

            $instaxer->instagram->likeMedia($hashTagFeedItem->getID());

            sleep(random_int(2, 5));
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
