<?php

namespace App\Aggregators\Dialog;

use App\Models\Dialog\Dialog;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

class DialogQueryBuilderAggregator
{
    private Builder $builder;

    public function __construct(array $relations = [])
    {
        $this->builder = Dialog::query()->with($relations);
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function byUser(User $user): static
    {
        $this->builder->whereHas('users', function (Builder $builder) use ($user) {
            $builder->where('id', $user->id);
        });

        return $this;
    }
}
