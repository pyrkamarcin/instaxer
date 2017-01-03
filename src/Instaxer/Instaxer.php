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

        $this->pb = new Manager(0, ($this->counter * $this->long) - 1, 120, '=', '-', '>');
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

                var_dump($hashTagFeedItem);

                if ($hashTagFeedItem->isImage()) {
                    $this->instagram->commentOnMedia($hashTagFeedItem->getID(), ':) !');
                    $this->instagram->likeMedia($hashTagFeedItem->getID());
                    sleep(random_int(2, 5));
                }

                $this->pb->update($this->marker++);
            }
            sleep(random_int(1, 5));
        }
    }
}
