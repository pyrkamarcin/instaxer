<?php

class TagFeedTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $instation = new \Instation\Instation('katase5522', 'katase@gamgling.com');

        $tag = 'instagram';
        $request = new \Instation\Request\TagFeed($instation);

        $tagFeed = $request->get($tag);

        $this->assertEquals('ok', $tagFeed->getStatus());
    }
}
