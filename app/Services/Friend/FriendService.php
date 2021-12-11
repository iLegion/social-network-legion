<?php

namespace App\Services\Friend;

use App\Models\User\User;

class FriendService
{
    public function addFriend(User $currentUser, User $user): bool
    {
        $currentUser->addFriend($user);

        return true;
    }
}
