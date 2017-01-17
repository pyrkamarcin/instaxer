<?php

require __DIR__ . '/vendor/autoload.php';
$instagram = new \Instagram\Instagram();
$instagram->login('jebthecat', 'TimeTravel256');

$user = $instagram->getUserByUsername('jebs_pap');

$getUserFeed = $instagram->getTimelineFeed($user);
var_dump(count($getUserFeed->getItems()));
$nextMaxId = $getUserFeed->getNextMaxId();
