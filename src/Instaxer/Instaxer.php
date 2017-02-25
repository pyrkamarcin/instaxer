<?php

namespace Instaxer;

use Instagram\Instagram;
use Instaxer\Domain\Model\ItemRepository;
use Instaxer\Domain\Session;

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

    /**
     * @var Session
     */
    public $session;

    /**
     * Instaxer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->instagram = new Instagram();
        $this->instagram->setVerifyPeer(false);


        $this->session = new Session(__DIR__ . '/../../session.dat');
        $this->session->restoredFromSession = FALSE;
        $this->marker = 0;
    }

    /**
     * @param string $user
     * @param string $password
     */
    public function login(string $user, string $password)
    {
        if ($this->session->checkExistsSessionFile()) {
            try {
                $savedSession = $this->session->getSevedSession();
                if ($savedSession !== FALSE) {
                    $this->instagram->initFromSavedSession($savedSession);
                    $currentUser = $this->instagram->getCurrentUserAccount();
                    if ($currentUser->getUser()->getUsername() == $user) {
                        $this->session->restoredFromSession = TRUE;
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }

        if (!$this->session->restoredFromSession) {
            $this->instagram->login($user, $password);
            $savedSession = $this->instagram->saveSession();
            $this->session->saveSession($savedSession);
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
