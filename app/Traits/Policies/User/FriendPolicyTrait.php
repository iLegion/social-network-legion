<?php

namespace App\Traits\Policies\User;

use App\Models\User;

trait FriendPolicyTrait
{
    public function getMyFriends(): bool
    {
        return true;
    }

    public function getFriends(User $user, User $model): bool
    {
        return true;
//        return $user->id === $model->id || $user->hasFriend($model) || $user->isAdmin();
    }
}
