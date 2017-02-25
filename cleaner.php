<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/session.dat';

    $instaxer = new \Instaxer\Instaxer($path);
    $instaxer->login($user1, $pass1);


    $file = file_get_contents(__DIR__ . '/storage.tmp');
    $haystack = explode(';', $file);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new \Instaxer\Request\Following($instaxer);
    $following = $following->getFollowing($account);

    foreach ($haystack as $username) {

        if (strlen($username) > 3) {

            echo $username . ' ';

            if (!empty($instaxer->instagram->searchUsers($username)->getUsers())) {
                $user = $instaxer->instagram->getUserByUsername($username);
                echo ' [ ' . $instaxer->instagram->unfollowUser($user)->getStatus() . ' ] ' . "\r\n";
            } else {
                echo ' [ fuck! ] ';
                echo ' Clean: ' . $username . "\r\n";
            }

            $file = file_get_contents(__DIR__ . '/storage.tmp');
            $newFile = str_replace($username . ';', '', $file);
            file_put_contents('storage.tmp', $newFile, LOCK_EX);
            sleep(1);
        }
    }

    if (file_exists('storage.tmp')) @unlink('storage.tmp');


} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
