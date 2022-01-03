<?php

namespace App\Policies;

use App\Traits\Policies\User\DialogPolicyTrait;
use App\Traits\Policies\User\FriendPolicyTrait;
use App\Traits\Policies\User\UserPolicyTrait;

class UserPolicy
{
    use UserPolicyTrait, FriendPolicyTrait, DialogPolicyTrait;
}
