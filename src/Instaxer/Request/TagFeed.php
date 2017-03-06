<?php

namespace Instaxer\Request;

use Instaxer\Request;

class TagFeed extends Request
{
    public function get(string $tag)
    {
        return $this->instaxer->instagram->getTagFeed($tag);
    }
}
