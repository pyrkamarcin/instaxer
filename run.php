<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$instagram = new \Instagram\Instagram();
$instagram->setVerifyPeer(false);

$counter = 5;

$sum = $counter * count($array);

$pb = new \ProgressBar\Manager(0, $sum, 80, '=', '-', '|');
$a = 0;

try {

    $instagram->login($user1, $pass1);

    foreach ($array as $item) {

        $hashTagFeed = $instagram->getTagFeed($item);
        $items = array_slice($hashTagFeed->getItems(), 0, $counter);

        foreach ($items as $hashTagFeedItem) {

            $user = $hashTagFeedItem->getUser();
            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();

            if ($hashTagFeedItem->isImage()) {
                $instagram->likeMedia($hashTagFeedItem->getID());
                sleep(random_int(4, 7));
            }

            $pb->update($a++);
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
