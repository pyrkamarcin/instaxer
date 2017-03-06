<?php

class DownloaderTest extends PHPUnit_Framework_TestCase
{
    public function testDrain()
    {
        if (file_exists(__DIR__ . '/../../app/storage/test.jpg')) {
            unlink(__DIR__ . '/../../app/storage/test.jpg');
        }

        $downloader = new \Instaxer\Downloader();
        $downloader->drain('https://www.google.pl/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png');

        $this->assertTrue(file_exists(__DIR__ . '/../../app/storage/test.jpg'));
    }
}
