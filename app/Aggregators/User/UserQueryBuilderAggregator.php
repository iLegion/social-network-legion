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
        $this->builder->whereNotIn('id', $user->friends()->pluck('friend_id'));

        return $this;
    }

    public function byName(string $value): static
    {
        $value = strtolower($value);

        $this->builder->where('name', 'like', "%$value%");

        return $this;
    }

    public function byPostsCount(bool $value): static
    {
        $order = $value ? 'desc' : 'asc';

        $this->builder->orderBy('posts_count', $order);

        return $this;
    }

    public function byFriendsCount(bool $value): static
    {
        $order = $value ? 'desc' : 'asc';

        $this->builder->orderBy('friends_count', $order);

        return $this;
    }
}
