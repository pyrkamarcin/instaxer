<?php

use Instaxer\Request\PublishPhoto;

class PublishPhotoTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $path = __DIR__ . '/../../../var/cache/instaxer/profiles/session.dat';
        $instaxer = new \Instaxer\Instaxer($path);
        $instaxer->login('vodefgafy', 'vodef@gafy.net');

        $request = new PublishPhoto($instaxer);
        $result = $request->pull(__DIR__ . '/test.jpg', 'test');

        $this->assertEquals('ok', $result->getStatus());
    }
}
