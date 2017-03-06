<?php

use Instation\Request\PublishPhoto;

class PublishPhotoTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $instation = new \Instation\Instation('katase5522', 'katase@gamgling.com');

        $request = new PublishPhoto($instation);
        $result = $request->pull(__DIR__ . '/test.jpg', 'test');

        $this->assertEquals('ok', $result->getStatus());
    }
}
