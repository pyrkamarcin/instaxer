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

        $restoredFromSession = FALSE;
        $sessionFile = __DIR__ . '/../../session.dat';
        if (is_file($sessionFile)) {
            try {
                $savedSession = file_get_contents($sessionFile);
                if ($savedSession !== FALSE) {
                    $this->instagram->initFromSavedSession($savedSession);
                    $currentUser = $this->instagram->getCurrentUserAccount();
                    if ($currentUser->getUser()->getUsername() == $user) {
                        $restoredFromSession = TRUE;
                    } else {
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }

        if (!$restoredFromSession) {
            $this->instagram->login($user, $password);
            $savedSession = $this->instagram->saveSession();

            $result = file_put_contents($sessionFile, $savedSession);
            if (!$result) {
                unlink($sessionFile);
            }
        }

        $this->counter = $counter;
        $this->long = $long;

        $this->marker = 0;
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
                $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

                echo 'User: ' . $user->getUsername() . ', ';
                echo '(id: ' . $id . '), ';
                echo 'followers: ' . $user->getFollowerCount() . ' (ratio: ' . round($followRatio, 1) . ') ';

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                echo '(' . $likeCount . '/' . $commentCount . ') ';

                if ($user->getFollowingCount() > 100) {
                    $this->instagram->likeMedia($hashTagFeedItem->getID());
                    echo '[liked] ';
                    sleep(random_int(5, 8));
                }

                sleep(random_int(5, 8));
                echo "\r\n";
            }
        }
    }
}
