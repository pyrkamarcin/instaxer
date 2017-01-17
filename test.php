<?php

require("vendor/autoload.php");
$instagram = new \Instagram\Instagram();
$instagram->setVerifyPeer(false);
$instagram->login("jebthecat", "TimeTravel256");

$user = $instagram->getUserByUsername('jebs_pap');
$userInfo = $instagram->getUserInfo($user);

$mediaCountMax = $userInfo->getUser()->getMediaCount();

$curentMaxId = '';
$array = [];

$getUserFeed = $instagram->getTimelineFeed($curentMaxId);
$nextMaxId = $getUserFeed->getNextMaxId();
$array = array_merge($array, $getUserFeed->getItems());

while ($nextMaxId !== null) {

    $getUserFeed = $instagram->getTimelineFeed($curentMaxId);
    $nextMaxId = $getUserFeed->getNextMaxId();

    $curentMaxId = $nextMaxId;
    $array = array_merge($array, $getUserFeed->getItems());

    echo $getUserFeed->getNumResults() . ' / ' . count($array) . "\r\n";

    sleep(3);
}

var_dump(count($array));
