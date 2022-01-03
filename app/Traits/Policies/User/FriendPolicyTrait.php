<?php

namespace App\Traits\Policies\User;

use App\Models\User\User;

trait FriendPolicyTrait
{
    public function getMyFriends(): bool
    {
        return true;
    }

    public function getFriends(User $user, User $model): bool
    {
        return $user->id === $model->id || $model->privacySettings->profile_display_mode;
    }

    public function store(User $user, User $model): bool
    {
        return true;
    }
}
