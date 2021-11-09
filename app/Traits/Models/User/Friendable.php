<?php

namespace App\Traits\Models\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @mixin User
 *
 * @property-read Collection $friends
 *
 * @property-read int friends_count
 */
trait Friendable
{
    public function hasFriend(User $user): bool
    {
        return $this->friends()->where('friend_id', $user->id)->exists();
    }
}
