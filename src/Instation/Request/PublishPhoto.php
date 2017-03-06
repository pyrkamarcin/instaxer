<?php

namespace Instation\Request;

use Instation\Request;

/**
 * Class PublishPhoto
 * @package Instation\Request
 */
class PublishPhoto extends Request
{
    /**
     * @param string $path
     * @param string $caption
     * @return \Instagram\API\Response\ConfigureMediaResponse
     */
    public function pull(string $path, string $caption)
    {
        return $this->instation->instagram->postPhoto($path, $caption);
    }
}
