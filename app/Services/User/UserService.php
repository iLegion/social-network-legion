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
    public function get(Collection $collection): Builder
    {
        $builder = (new UserQueryBuilderAggregator(['privacySettings', 'roles'], ['posts', 'friends']))
            ->byNotClosedProfilesInPrivacySettings();

        if ($collection->has('name')) {
            $builder->byName($collection->get('name'));
        }

        if ($collection->has('byPostsCount')) {
            $builder->byPostsCount($collection->get('byPostsCount'));
        }

        if ($collection->has('byFriendsCount')) {
            $builder->byFriendsCount($collection->get('byFriendsCount'));
        }

        return $builder->getBuilder();
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

        if ($collection->has('avatar')) {
            $updater->setAvatar($collection->get('avatar'));
        }

        return $updater->update();
    }
}
