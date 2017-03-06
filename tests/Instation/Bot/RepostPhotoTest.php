<?php

class RepostPhotoTest extends PHPUnit_Framework_TestCase
{
    public function testExec()
    {
        $instation = new \Instation\Instation('katase5522', 'katase@gamgling.com');
        $request = new \Instation\Bot\RepostPhoto($instation);
        $result = $request->exec('instagram');

        $this->assertEquals('ok', $result->getStatus());
    }
}
