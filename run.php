<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($user1, $pass1);

    $counter = 50;
    $long = 20;

    $itemRepository = new \Instaxer\Domain\Model\ItemRepository($array);

    for ($c = 0; $c < $counter; $c++) {

        $item = $itemRepository->getRandomItem();

        echo sprintf('#%s: ' . "\r\n", $item->getItem());

        $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());
        $items = array_slice($hashTagFeed->getItems(), 0, $long);

        foreach ($items as $hashTagFeedItem) {

            $id = $hashTagFeedItem->getId();
            $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
            $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

            echo sprintf('User: %s; ', $user->getUsername());
            echo sprintf('id: %s,  ', $id);
            echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();

            echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

            if ($user->getFollowingCount() > 100) {
                $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                echo sprintf('[liked] ');
            }

            sleep(random_int(2, 5));
            echo sprintf("\r\n");
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
