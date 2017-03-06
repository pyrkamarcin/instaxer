<?php

namespace Instation\Bot;

use Instation\Downloader;
use Instation\Request;

/**
 * Class RepostPhoto
 * @package Instation\Bot
 */
class RepostPhoto extends Request
{
    /**
     * @param string $userName
     * @return \Instagram\API\Response\ConfigureMediaResponse
     */
    public function exec(string $userName)
    {
        $request = new Request\UserFeed($this->instation);
        $userFeed = $request->get($this->instation->instagram->getUserByUsername($userName));

        $feedItems = $userFeed->getItems();
        $lastFeedItem = $feedItems[0];

        $image = $lastFeedItem->getImageVersions2()->getCandidates();

        $downloader = new Downloader();
        $downloader->drain($image[0]->getUrl());

        $requestPublishPhoto = new Request\PublishPhoto($this->instation);

        return $requestPublishPhoto->pull(__DIR__ . '/../../../app/storage/test.jpg',
            'Repost from: @' . $userName . '. ' . "\r\n" .
            $lastFeedItem->getCaption()->getText());
    }
}
