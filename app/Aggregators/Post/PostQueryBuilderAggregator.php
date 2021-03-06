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

    public function byAuthors(array $usersIDs): static
    {
        $this->builder->whereHas('author', function (Builder $builder) use ($usersIDs) {
            $builder->whereIn('id', $usersIDs);
        });

        return $this;
    }

    public function byLikesCount(bool $value): static
    {
        $order = $value ? 'desc' : 'asc';

        $this->builder->orderBy('likes_count', $order);

        return $this;
    }

    public function byViewsCount(bool $value): static
    {
        $order = $value ? 'desc' : 'asc';

        $this->builder->orderBy('views_count', $order);

        return $this;
    }
}
