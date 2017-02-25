<?php

namespace Instaxer\Request;

class Followers
{
    private $instaxer;

    public function __construct($instaxer)
    {
        $this->instaxer = $instaxer;
    }

    public function getFollowers($user)
    {
        $followersCount = $this->instaxer->instagram->getUserInfo($user)->getUser()->getFollowerCount();

        $array = [];
        $counter = ceil($followersCount / 200);

        $lastId = $user;

        for ($i = 1; $i <= $counter; $i++) {
            $fall = $this->instaxer->instagram->getUserFollowers($user, $lastId);
            $lastId = $fall->getNextMaxId();
            $array = array_merge($array, $fall->getFollowers());
        }

        return $array;
    }
}
