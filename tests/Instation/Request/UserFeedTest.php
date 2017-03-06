<?php

class UserFeedTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $instation = new \Instation\Instation('katase5522', 'katase@gamgling.com');
        $user = $instation->instagram->getUserByUsername('instagram');
        $request = new \Instation\Request\UserFeed($instation);

        $userFeed = $request->get($user);

        $this->assertEquals('ok', $userFeed->getStatus());
    }
}
