<?php

namespace Instaxer;

use Instagram\Instagram;
use Instaxer\Domain\Model\ItemRepository;

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
    public $instagram;

    public $restoredFromSession;

    public $sessionFile;

    /**
     * Instaxer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->instagram = new Instagram();
        $this->instagram->setVerifyPeer(false);

        $this->restoredFromSession = FALSE;
        $this->sessionFile = __DIR__ . '/../../session.dat';

        $this->marker = 0;
    }

    public function login(string $user, string $password)
    {
        if (is_file($this->sessionFile)) {
            try {
                $savedSession = file_get_contents($this->sessionFile);
                if ($savedSession !== FALSE) {
                    $this->instagram->initFromSavedSession($savedSession);
                    $currentUser = $this->instagram->getCurrentUserAccount();
                    if ($currentUser->getUser()->getUsername() == $user) {
                        $this->restoredFromSession = TRUE;
                    } else {
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }

        if (!$this->restoredFromSession) {
            $this->instagram->login($user, $password);
            $savedSession = $this->instagram->saveSession();

            $result = file_put_contents($this->sessionFile, $savedSession);
            if (!$result) {
                unlink($this->sessionFile);
            }
        }
    }

    /**
     * @param ItemRepository $itemRepository
     * @throws \Exception
     */
    public function run(ItemRepository $itemRepository)
    {
        for ($c = 0; $c < $this->counter; $c++) {

            $item = $itemRepository->getRandomItem();

            echo sprintf('#%s: ' . "\r\n", $item->getItem());

            $hashTagFeed = $this->instagram->getTagFeed($item->getItem());
            $items = array_slice($hashTagFeed->getItems(), 0, $this->long);

            foreach ($items as $hashTagFeedItem) {

                $id = $hashTagFeedItem->getId();
                $user = $this->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

                echo sprintf('User: %s; ', $user->getUsername());
                echo sprintf('id: %s,  ', $id);
                echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

                if ($user->getFollowingCount() > 100) {
                    $this->instagram->likeMedia($hashTagFeedItem->getID());
                    echo sprintf('[liked] ');
                }

                sleep(random_int(2, 5));
                echo sprintf("\r\n");
            }
        }
    }
}
