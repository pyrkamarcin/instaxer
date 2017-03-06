<?php

namespace Instation\Request;

use Instation\Request;

/**
 * Class TagFeed
 * @package Instation\Request
 */
class TagFeed extends Request
{
    /**
     * @param string $tag
     * @return \Instagram\API\Response\TagFeedResponse
     */
    public function get(string $tag)
    {
        return $this->instation->instagram->getTagFeed($tag);
    }
}
