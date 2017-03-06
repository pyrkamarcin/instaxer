<?php

namespace Instaxer\Request;

use Instagram\API\Response\Model\User;
use Instaxer\Request;

class UserFeed extends Request
{
    public function get(User $user)
    {
        return $this->instaxer->instagram->getUserFeed($user);
    }
}
