<?php

namespace App\Traits\Models\User;

use App\Models\User;

/**
 * @mixin User
 */
trait Friendable
{
    public function hasFriend(User $user): bool
    {
        return $this->friends()->where('friend_id', $user->id)->exists();
    }
}
