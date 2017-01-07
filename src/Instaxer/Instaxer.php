<?php

namespace Instaxer;

use Instagram\Instagram;
use Instaxer\Model\ItemRepository;

/**
 * Class Instaxer
 * @package Instaxer
 */
class Instaxer
{
    /**
     * @var int
     */
    public $counter;
    /**
     * @var int
     */
    public $long;
    /**
     * @var int
     */
    public $marker;
    /**
     * @var Instagram
     */
    private $instagram;

    /**
     * Instaxer constructor.
     * @param string $user
     * @param string $password
     * @param int $counter
     * @param int $long
     * @throws \Exception
     */
    public function __construct(string $user, string $password, int $counter = 10, int $long = 2)
    {
        $this->instagram = new Instagram();
        $this->instagram->setVerifyPeer(false);

        $this->counter = $counter;
        $this->long = $long;

        $this->marker = 0;

        $this->instagram->login($user, $password);
    }

    /**
     * @param ItemRepository $itemRepository
     * @throws \Exception
     */
    public function run(ItemRepository $itemRepository)
    {

        for ($c = 0; $c < $this->counter; $c++) {

            $item = $itemRepository->getRandomItem();

            echo '#' . $item->getItem() . ': ' . "\r\n";

            $hashTagFeed = $this->instagram->getTagFeed($item->getItem());
            $items = array_slice($hashTagFeed->getItems(), 0, $this->long);

            foreach ($items as $hashTagFeedItem) {

                $id = $hashTagFeedItem->getId();
                $user = $this->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                $followRatio = $user->getFollowingCount() / $user->getFollowerCount();

                echo 'User: ' . $user->getUsername() . ', ';
                echo '(id: ' . $id . '), ';
                echo 'following: ' . $user->getFollowingCount() . ' (ratio: ' . round($followRatio, 1) . ') ';

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                echo '(' . $likeCount . '/' . $commentCount . ') ';

                if ($user->getFollowingCount() > 400 || $likeCount > 1) {
                    $this->instagram->likeMedia($hashTagFeedItem->getID());
                    echo '[liked] ';
                    sleep(random_int(5, 8));
                }

                $file = file_get_contents('storage.tmp');
                $haystack = explode(';', $file);

                if (!in_array($hashTagFeedItem->getID(), $haystack, true)) {

                    if ($user->getFollowingCount() > 1000 & $followRatio > 0.55) {
                        sleep(random_int(0, 1));
                        $this->instagram->commentOnMedia($hashTagFeedItem->getID(), ':)');
                        file_put_contents('storage.tmp', $hashTagFeedItem->getID() . ';', FILE_APPEND);
                        echo '[commented] ';
                        sleep(random_int(5, 15));
                    }

                    if ($user->getFollowingCount() > 500 & $commentCount > 2 & $followRatio > 1.5) {
                        sleep(random_int(0, 1));
                        $this->instagram->commentOnMedia($hashTagFeedItem->getID(), '@jebs_pap @jebs_mam must see!');
                        file_put_contents('storage.tmp', $hashTagFeedItem->getID() . ';', FILE_APPEND);
                        echo '[makred] ';
                        sleep(random_int(5, 8));
                    }

                } else {
                    echo '[skipped] ';
                }

                sleep(random_int(5, 8));
                echo "\r\n";
            }
        }
    }
}
