<?php

namespace Instaxer\Bot;

use Instaxer\Downloader;
use Instaxer\Request;

class RepostPhoto extends Request
{

    public function exec(string $userName)
    {
        $request = new Request\UserFeed($this->instaxer);
        $userFeed = $request->get($this->instaxer->instagram->getUserByUsername($userName));

        $feedItems = $userFeed->getItems();
        $lastFeedItem = $feedItems[0];

        $image = $lastFeedItem->getImageVersions2()->getCandidates();

        $downloader = new Downloader();
        $downloader->drain($image[0]->getUrl());

        $requestPublishPhoto = new Request\PublishPhoto($this->instaxer);

        return $requestPublishPhoto->pull(__DIR__ . '/../../../app/storage/test.jpg',
            'Repost from: @' . $userName . '. ' . "\r\n" .
            $lastFeedItem->getCaption()->getText());
    }
}
