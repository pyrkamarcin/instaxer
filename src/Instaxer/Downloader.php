<?php

namespace Instaxer;

use Ramsey\Uuid\Uuid;

class Downloader
{
    /**
     * @param $path
     */
    public function drain($path)
    {
        file_put_contents(__DIR__ . '/../../app/storage/' . Uuid::uuid4()->toString() . '.jpg', fopen($path, 'r'));
    }
}
