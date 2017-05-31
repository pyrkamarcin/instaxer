<?php

namespace Instaxer\Survey;

use Instagram\API\Response\Model\FeedItem;

class Survey
{

    private $commentCount;
    private $likeCount;

    public function __construct(FeedItem $item)
    {
        $this->commentCount = $item->getCommentCount();
        $this->likeCount = $item->getLikeCount();
    }
}
