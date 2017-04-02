<?php

class RepostPhotoTest extends PHPUnit_Framework_TestCase
{
    public function testExec()
    {
        $path = __DIR__ . '/../../../var/cache/instaxer/profiles/session.dat';
        $instaxer = new \Instaxer\Instaxer($path);
        $instaxer->login('vodefgafy', 'vodef@gafy.net');

        $request = new \Instaxer\Bot\RepostPhoto($instaxer);
        $result = $request->exec('instagram');

        $this->assertEquals('ok', $result->getStatus());
    }
}
