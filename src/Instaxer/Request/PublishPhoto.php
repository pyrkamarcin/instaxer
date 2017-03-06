<?php

namespace Instaxer\Request;

use Instaxer\Request;

class PublishPhoto extends Request
{
    public function pull(string $path, string $caption)
    {
        return $this->instaxer->instagram->postPhoto($path, $caption);
    }
}
