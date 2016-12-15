<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . 'config.php';

$instagram = new \Instagram\Instagram();

$array = [
    'topmodelpolska',
    'sensual_shots',
    'sensual_shots_',
    'bravogreatphoto',
    'boudiorphotography',
    'beautyandboudior',
    'portretpage',
    'portraitvision',
    'portrait_vision',
    'pursuitofportraits',
    'majestic_people',
    'portraitfestival',
    'hunterportrait',
    'portraitmag'
];

$sum = 20 * count($array);

$pb = new \ProgressBar\Manager(0, $sum, 80, '=', '-', '|');
$a = 0;

try {

    $instagram->login($user, $pass);

    foreach ($array as $item) {

        $hashTagFeed = $instagram->getTagFeed($item);
        $items = array_slice($hashTagFeed->getItems(), 0, 20);

        foreach ($items as $hashTagFeedItem) {

            $user = $hashTagFeedItem->getUser();
            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();

            $instagram->likeMedia($hashTagFeedItem);

            $pb->update($a++);
            sleep(random_int(4, 9));
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
