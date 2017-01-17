<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);


    $file = file_get_contents(__DIR__ . '/storage.tmp');
    $haystack = explode(';', $file);


    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();
    $following = $instaxer->getFollowing($account);

    var_dump(count($following));

    foreach ($haystack as $username) {

        if (strlen($username) > 3) {

            $user = $instaxer->instagram->getUserByUsername($username);
            echo $user->getUsername() . ' [ ... ] ';

            echo ' [' . $instaxer->instagram->unfollowUser($user)->getStatus() . '] ' . "\r\n";

            sleep(10);
        }
    }

    if (file_exists('storage.tmp')) @unlink('storage.tmp');


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
