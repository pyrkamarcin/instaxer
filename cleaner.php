<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {

    $instaxer = new \Instaxer\Instaxer($user1, $pass1);


    $file = file_get_contents(__DIR__ . '/storage.tmp');
    $haystack = explode(';', $file);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();
    $following = $instaxer->getFollowing($account);

    foreach ($haystack as $username) {

        if (strlen($username) > 3) {

            if (!empty($instaxer->instagram->searchUsers($username)->getUsers())) {
                $user = $instaxer->instagram->getUserByUsername($username);
                echo $user->getUsername() . ' [ ... ] ';
                echo ' [' . $instaxer->instagram->unfollowUser($user)->getStatus() . '] ' . "\r\n";
            } else {
                echo ' [ fuck! ] ';
                echo ' Clean: ' . $username . "\r\n";
            }

            $file = file_get_contents(__DIR__ . '/storage.tmp');
            $newFile = str_replace($username . ';', '', $file);
            file_put_contents('storage.tmp', $newFile, LOCK_EX);
            sleep(2);
        }
    }

    if (file_exists('storage.tmp')) @unlink('storage.tmp');


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
