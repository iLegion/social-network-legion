<?php

namespace App\Services\User;

use App\Aggregators\User\UserCreatorAggregator;
use App\Aggregators\User\UserQueryBuilderAggregator;
use App\Aggregators\User\UserUpdaterAggregator;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserService
{
    public function get(): Builder
    {
        return (new UserQueryBuilderAggregator(['roles'], ['posts', 'friends']))
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

    public function update(User $user, Collection $collection): User
    {
        $updater = new UserUpdaterAggregator($user);

        if ($collection->has('name')) {
            $updater->setName($collection->get('name'));
        }

        if ($collection->has('email')) {
            $updater->setEmail($collection->get('email'));
        }

        if ($collection->has('password')) {
            $updater->setPassword($collection->get('password'));
        }

        return $updater->update();
    }
}
