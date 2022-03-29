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

    /**
     * @param Collection<int, User> $users
     * @return \Illuminate\Support\Collection
     */
    public function hasFriends(Collection $users): \Illuminate\Support\Collection
    {
        return $this->friends()->select(['user_id'])->whereIn('friend_id', $users->pluck('id'))->pluck('user_id');
    }

    public function addFriend(User $user): void
    {
        $this->friends()->attach($user->id, [
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
