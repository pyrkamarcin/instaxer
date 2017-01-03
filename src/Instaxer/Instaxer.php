<?php

namespace Instaxer;

use Instagram\Instagram;
use ProgressBar\Manager;

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
     * @param array $array
     * @throws \Exception
     */
    public function run(array $array)
    {
        for ($c = 0; $c < $this->counter; $c++) {

            $item = $array[random_int(0, count($array) - 1)];

            $hashTagFeed = $this->instagram->getTagFeed($item);
            $items = array_slice($hashTagFeed->getItems(), 0, $this->long);

            foreach ($items as $hashTagFeedItem) {

                $user = $hashTagFeedItem->getUser();

                echo 'User: ' . $user->getUsername() . ' ';

                var_dump($this->instagram->getUserInfo($user));

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                echo '(' . $likeCount . '/' . $commentCount . ') ';

                if ($likeCount > 2) {
                    $this->instagram->likeMedia($hashTagFeedItem->getID());
                    echo '[liked] ';
                    sleep(random_int(2, 5));
                }

                if ($commentCount > 8) {
                    $this->instagram->commentOnMedia($hashTagFeedItem->getID(), 'Great !!');
                    echo '[commented] ';
                    sleep(random_int(2, 5));
                }

                echo "\r\n";
            }
            sleep(random_int(1, 2));
        }
    }
}
