<?php

namespace App\Aggregators\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilderAggregator
{
    private Builder $builder;

    public function __construct(array $relations = [])
    {
        $this->builder = Post::query()->with($relations);
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}
