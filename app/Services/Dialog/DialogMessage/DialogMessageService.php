<?php

namespace App\Services\Dialog\DialogMessage;

use App\Aggregators\Dialog\DialogMessage\DialogMessageCreatorAggregator;
use App\Aggregators\Dialog\DialogMessage\DialogMessageQueryBuilderAggregator;
use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DialogMessageService
{
    public function getByDialog(Dialog $dialog): Builder
    {
        return (new DialogMessageQueryBuilderAggregator())
            ->byDialog($dialog)
            ->getBuilder();
    }

    public function create(Collection $collection, Dialog $dialog, User $user): DialogMessage
    {
        return (new DialogMessageCreatorAggregator())
            ->setDialog($dialog)
            ->setUser($user)
            ->setText($collection->get('text'))
            ->create();
    }
}
