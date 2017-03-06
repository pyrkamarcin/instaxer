<?php

class InstationTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $instation = new \Instation\Instation('katase5522', 'katase@gamgling.com');
        $this->assertEquals('APITESTUSER', $instation->instagram->getLoggedInUser()->getFullName());
    }
}
