<?php

namespace App\Aggregators\Post;

use App\Models\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilderAggregator
{
    private Post | Builder $builder;

    public function __construct(array $relations = [], array $withCounts = [])
    {
        $this->builder = Post::query()
            ->with($relations)
            ->withCount($withCounts);
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function byAuthor(User $user): static
    {
        $this->builder->whereHas('author', function (Builder $builder) use ($user) {
            $builder->where('id', $user->id);
        });

        return $this;
    }

    public function byNotAuthor(User $user): static
    {
        $this->builder->whereHas('author', function (Builder $builder) use ($user) {
            $builder->whereIn('id', $user->friends()->select('users.id')->pluck('id'));
        });

        return $this;
    }

    public function byLikes(): static
    {
        $this->builder->orderByDesc('likes_count');

        return $this;
    }

    public function byViews(): static
    {
        $this->builder->orderByDesc('views_count');

        return $this;
    }

    public function byLatest(): static
    {
        $this->builder->latest();

        return $this;
    }
}
