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
}
