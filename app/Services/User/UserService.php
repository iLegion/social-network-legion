<?php

namespace App\Services\User;

use App\Aggregators\User\UserCreatorAggregator;
use App\Models\User\User;
use Illuminate\Support\Collection;

class UserService
{
    public function create(Collection $collection): User
    {
        return (new UserCreatorAggregator())
            ->setEmail($collection->get('email'))
            ->setName($collection->get('name'))
            ->setPassword($collection->get('password'))
            ->create();
    }
}
