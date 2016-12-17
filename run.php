<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$instagram = new \Instagram\Instagram();
$instagram->setVerifyPeer(false);

$sum = 4 * count($array);

$pb = new \ProgressBar\Manager(0, $sum, 80, '=', '-', '|');
$a = 0;

try {

    $instagram->login($user, $pass);

    foreach ($array as $item) {

        $hashTagFeed = $instagram->getTagFeed($item);
        $items = array_slice($hashTagFeed->getItems(), 0, 4);

        foreach ($items as $hashTagFeedItem) {

            $user = $hashTagFeedItem->getUser();
            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();


            $instagram->likeMedia($hashTagFeedItem->getID());

            $pb->update($a++);
            sleep(random_int(8, 16));
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
