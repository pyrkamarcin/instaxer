<?php

class TagFeedTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $path = __DIR__ . '/../../../var/cache/instaxer/profiles/session.dat';
        $instaxer = new \Instaxer\Instaxer($path);
        $instaxer->login('vodefgafy', 'vodef@gafy.net');

        $tag = 'instagram';
        $request = new \Instaxer\Request\TagFeed($instaxer);

        $tagFeed = $request->get($tag);

        $this->assertEquals('ok', $tagFeed->getStatus());
    }
}
