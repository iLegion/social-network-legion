<?php

namespace App\Aggregators\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilderAggregator
{
    private Builder $builder;

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
}
