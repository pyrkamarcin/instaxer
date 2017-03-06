<?php

namespace Instation\Request;

use Instagram\API\Response\Model\User;
use Instation\Request;

/**
 * Class UserFeed
 * @package Instation\Request
 */
class UserFeed extends Request
{
    /**
     * @param User $user
     * @return \Instagram\API\Response\UserFeedResponse
     */
    public function get(User $user)
    {
        return $this->instation->instagram->getUserFeed($user);
    }
}
