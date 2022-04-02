<?php

namespace App\Traits\Models\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @mixin User
 *
 * @property-read Collection<int, User> $friends
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
     * @param array $usersIDs
     * @return \Illuminate\Support\Collection
     */
    public function hasFriends(array $usersIDs): \Illuminate\Support\Collection
    {
        return $this
            ->friends()
            ->select(['friend_id'])
            ->whereIn('friend_id', $usersIDs)
            ->pluck('friend_id');
    }

    public function addFriend(User $user): void
    {
        $this->friends()->attach($user->id, [
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
