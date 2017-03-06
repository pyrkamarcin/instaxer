<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $path = __DIR__ . '/../var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($array[1]['username'], $array[1]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new \Instaxer\Request\Following($instaxer);
    $followers = new \Instaxer\Request\Followers($instaxer);

    $following = $following->getFollowing($account);
    $followers = $followers->getFollowers($account);

    $itemRepository = new \Instaxer\Domain\Model\ItemRepository($array[1]['tags']);
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
                file_put_contents('storage.tmp', $user->getUsername() . ';', FILE_APPEND);
                sleep(5);
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
