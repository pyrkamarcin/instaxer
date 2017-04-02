<?php

class UserFeedTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $path = __DIR__ . '/../../../var/cache/instaxer/profiles/session.dat';
        $instaxer = new \Instaxer\Instaxer($path);
        $instaxer->login('vodefgafy', 'vodef@gafy.net');

        $user = $instaxer->instagram->getUserByUsername('instagram');
        $request = new \Instaxer\Request\UserFeed($instaxer);

        $userFeed = $request->get($user);

        $this->assertEquals('ok', $userFeed->getStatus());
    }
}
