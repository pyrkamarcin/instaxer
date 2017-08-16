<?php

use Instaxer\Domain\Model\ItemRepository;
use Instaxer\Instaxer;
use Instaxer\Request\Followers;
use Instaxer\Request\Following;
use Symfony\Component\Filesystem\Filesystem;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $pathDir = __DIR__ . '/../var/cache/instaxer/profiles/';
    $path = $pathDir . $array[$argv[1]]['username'] . '.dat';

    $fs = new Filesystem();
    $fs->mkdir($pathDir);

    $instaxer = new Instaxer($path);
    $instaxer->login($array[$argv[1]]['username'], $array[$argv[1]]['password']);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new Following($instaxer);
    $following = $following->getFollowing($account);

    $followers = new Followers($instaxer);
    $followers = $followers->getFollowers($account);

    $itemRepository = new ItemRepository($array[$argv[1]]['tags']);

    while (true) {
        for ($c = 0; $c < 5; $c++) {
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
                        sleep(random_int(1, 5));
                    }
                }
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
