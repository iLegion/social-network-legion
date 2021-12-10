<?php

namespace App\Services\User;

use App\Aggregators\User\UserCreatorAggregator;
use App\Aggregators\User\UserQueryBuilderAggregator;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserService
{
    public function get(): Builder
    {
        return (new UserQueryBuilderAggregator([], ['posts', 'friends']))
            ->getBuilder();
    }

    public function create(Collection $collection): User
    {
        return (new UserCreatorAggregator())
            ->setEmail($collection->get('email'))
            ->setName($collection->get('name'))
            ->setPassword($collection->get('password'))
            ->create();
    }
}
