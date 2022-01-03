<?php

namespace App\Aggregators\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilderAggregator
{
    private User | Builder $builder;

    public function __construct(array $relations = [], array $withCounts = [])
    {
        $this->builder = User::query()
            ->with($relations)
            ->withCount($withCounts);
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function byNotClosedProfilesInPrivacySettings(): static
    {
        $this->builder->whereHas('privacySettings', function (Builder $builder) {
            $builder
                ->select(['id', 'profile_display_mode'])
                ->where('profile_display_mode', 1);
        });

        return $this;
    }

    public function byNotFriendsFor(User $user): static
    {
        $this->builder
            ->whereNotIn('id', $user->friends()->pluck('friend_id'));

        return $this;
    }
}
