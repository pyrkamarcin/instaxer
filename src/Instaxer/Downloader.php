<?php

namespace Instaxer;

class Downloader
{
    /**
     * @param $path
     */
    public function drain($path)
    {
        file_put_contents(__DIR__ . '/../../app/storage/test.jpg', fopen($path, 'r'));
    }
}
