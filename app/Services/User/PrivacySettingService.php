<?php

namespace App\Services\User;

use App\Aggregators\User\PrivacySettingCreatorAggregator;
use App\Models\User\PrivacySetting;
use App\Models\User\User;
use Illuminate\Support\Collection;

class PrivacySettingService
{
    public function create(Collection $collection, User $user): PrivacySetting
    {
        return (new PrivacySettingCreatorAggregator())
            ->setUser($user)
            ->setProfileDisplayMode($collection->get('profileDisplayMode'))
            ->setAddFriendsMode($collection->get('addFriendsMode'))
            ->setMessageWritingMode($collection->get('messageWritingMode'))
            ->create();
    }
}
