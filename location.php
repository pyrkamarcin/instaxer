<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);

    $locations = $instaxer->instagram->searchFacebookPlacesByLocation(52.408448, 16.933845);

    foreach ($locations->getItems() as $location) {
        dump($instaxer->instagram->getLocationFeed($location->getLocation()));
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
