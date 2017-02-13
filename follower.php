<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1, 2, 5);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();
    $following = $instaxer->getFollowing($account);
    $followers = $instaxer->getFollowers($account);

    $itemRepository = new \Instaxer\Domain\Model\ItemRepository($array);
    $item = $itemRepository->getRandomItem();
    $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());

    $elements = $hashTagFeed->getItems();

    foreach ($elements as $hashTagFeedItem) {
        $id = $hashTagFeedItem->getId();
        $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();

        $userFollow = false;

        foreach ($following as $followingUser) {
            if ($followingUser->getUsername() === $user->getUsername()) {
                $userFollow = true;
            }
        }
        $file = file_get_contents('storage.tmp');
        $haystack = explode(';', $file);
        if (!in_array($user->getUsername(), $haystack, true)) {
            if ($userFollow !== true) {
                echo $user->getUsername() . ' nie obserwuje mnie' . "\r\n";
                $instaxer->instagram->followUser($user);

                $hashTagFeed = $instaxer->instagram->getUserFeed($user);
                $items = array_slice($hashTagFeed->getItems(), 0, random_int(3, 7));
                foreach ($items as $hashTagFeedItem) {
                    $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                    echo sprintf('[ liked ] ');
                    sleep(random_int(3, 7));
                }


                file_put_contents('storage.tmp', $user->getUsername() . ';', FILE_APPEND);
                sleep(random_int(1, 4));
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
