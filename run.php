<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$instagram = new \Instagram\Instagram();
$instagram->setVerifyPeer(false);

$counter = 250;
$long = 5;


$pb = new \ProgressBar\Manager(0, ($counter * $long) - 1, 80, '=', '-', '>');
$a = 0;

try {

    $instagram->login($user1, $pass1);

    for ($c = 0; $c < $counter; $c++) {

        $item = $array[mt_rand(0, count($array) - 1)];

        $hashTagFeed = $instagram->getTagFeed($item);
        $items = array_slice($hashTagFeed->getItems(), 0, $long);

        foreach ($items as $hashTagFeedItem) {

            $user = $hashTagFeedItem->getUser();
            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();

            if ($hashTagFeedItem->isImage()) {
                $instagram->likeMedia($hashTagFeedItem->getID());
                sleep(random_int(2, 5));
            }

            $pb->update($a++);
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
