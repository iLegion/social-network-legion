<?php

namespace App\Services\Dialog;

use App\Aggregators\Dialog\DialogCreatorAggregator;
use App\Aggregators\Dialog\DialogQueryBuilderAggregator;
use App\Models\Dialog\Dialog;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DialogService
{
    public function getMyDialogs(User $user): Builder
    {
        return (new DialogQueryBuilderAggregator())
            ->byUser($user)
            ->getBuilder();
    }

    public function create(Collection $collection, Collection $users, User $owner): Dialog
    {
        return (new DialogCreatorAggregator())
            ->setTitle($collection->get('title'))
            ->setOwner($owner)
            ->create()
            ->setUsers($users)
            ->getBuilder();
    }

    public function delete(Dialog $dialog): ?bool
    {
        return $dialog->delete();
    }
}
