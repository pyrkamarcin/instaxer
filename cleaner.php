<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);


    $file = file_get_contents('storage.tmp');
    $haystack = explode(';', $file);

    foreach ($haystack as $username) {

        if (strlen($username) > 3) {

            $user = $instaxer->instagram->getUserByUsername($username);
            $instaxer->instagram->unfollowUser($user);
            sleep(1);
        }
    }

    if (file_exists('storage.tmp')) @unlink('storage.tmp');


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();