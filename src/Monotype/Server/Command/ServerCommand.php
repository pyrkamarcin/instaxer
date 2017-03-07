<?php

namespace Monotype\Server\Command;

use Instaxer\Domain\Model\ItemRepository;
use Instaxer\Instaxer;
use Instaxer\Request\Following;
use Monotype\Server\Command;
use React\Datagram\Socket;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ServerCommand
 * @package Monotype\Server\Command
 */
class ServerCommand extends Command
{
    /**
     * @param SymfonyStyle $inputOutput
     * @param Socket $client
     */
    public function close(SymfonyStyle $inputOutput, Socket $client)
    {
        $inputOutput->warning('Server stopped.');
        $client->close();
        die();
    }

    /**
     * @param SymfonyStyle $inputOutput
     */
    public function test(SymfonyStyle $inputOutput)
    {
        $inputOutput->caution('This is only simple test.');
    }

    /**
     * @param SymfonyStyle $inputOutput
     */
    public function run(SymfonyStyle $inputOutput)
    {
        require __DIR__ . '/../../../../config/config.php';

        $path = __DIR__ . '/../../../../var/cache/instaxer/profiles/session.dat';

        $instaxer = new Instaxer($path);
        $instaxer->login($array[1]['username'], $array[1]['password']);

        $counter = 2;
        $long = 5;

        $itemRepository = new ItemRepository($array[1]['tags']);

        for ($c = 0; $c < $counter; $c++) {

            $item = $itemRepository->getRandomItem();

            $inputOutput->text(sprintf('#%s: ' . "\r\n", $item->getItem()));

            $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());
            $items = array_slice($hashTagFeed->getItems(), 0, $long);

            foreach ($items as $hashTagFeedItem) {

                $id = $hashTagFeedItem->getId();
                $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

                $inputOutput->text(sprintf('User: %s; ', $user->getUsername()));
                $inputOutput->text(sprintf('id: %s,  ', $id));
                $inputOutput->text(sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1)));

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                $inputOutput->text(sprintf('photo: %s/%s ', $likeCount, $commentCount));

                if ($user->getFollowingCount() > 100) {
                    $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                    $inputOutput->text(sprintf('[liked] '));
                }

                sleep(random_int(10, 15));
                echo sprintf("\r\n");
            }

            sleep(random_int(1, 5));
        }
    }


    public function cleaner(SymfonyStyle $inputOutput)
    {
        require __DIR__ . '/../../../../config/config.php';

        $path = __DIR__ . '/../../../../var/cache/instaxer/profiles/session.dat';

        $instaxer = new Instaxer($path);
        $instaxer->login($array[1]['username'], $array[1]['password']);

        $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

        $following = new Following($instaxer);
        $following = $following->getFollowing($account);

//        $whiteList = new WhiteList(__DIR__ . '/whitelist.dat');

        echo 'Current count: ' . count($following) . "\r\n";
//        echo 'White list count: ' . $whiteList->count() . "\r\n";

        for ($c = 1; $c <= 20; $c++) {


            $profile = $following[random_int(0, count($following) - 1)];

            $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

            $userMostImportantStat = $user->getFollowerCount();

//            if (!$whiteList->check($profile->getUserName())) {

            if ($userMostImportantStat < 50000) {
                echo $c . ": \t";
                $instaxer->instagram->unfollowUser($user);
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";

                sleep(random_int(3, 10));
            } else {

                echo $c . ": \t";
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ skip - too preaty ! ] ' . "\r\n";

                sleep(random_int(2, 6));
            }
//            } else {
//                echo $c . ": \t";
//                echo $user->getUsername() . ' [ skip - whitelist member ] ' . "\r\n";
//            }


        }
    }
}
