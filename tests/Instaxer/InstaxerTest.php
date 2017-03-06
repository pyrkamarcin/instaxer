<?php

class InstaxerTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $path = __DIR__ . '/../../var/cache/instaxer/profiles/session.dat';
        $instaxer = new \Instaxer\Instaxer($path);
        $instaxer->login('katase5522', 'katase@gamgling.com');

        $this->assertEquals('APITESTUSER', $instaxer->instagram->getLoggedInUser()->getFullName());
    }

}
