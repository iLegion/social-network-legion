<?php

namespace App\Services\User;

use App\Aggregators\User\PrivacySetting\PrivacySettingCreatorAggregator;
use App\Aggregators\User\PrivacySetting\PrivacySettingUpdaterAggregator;
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

    public function update(Collection $collection, PrivacySetting $privacySetting): PrivacySetting
    {
        $updater = new PrivacySettingUpdaterAggregator($privacySetting);

        if ($collection->has('profileDisplayMode')) {
            $updater->setProfileDisplayMode($collection->get('profileDisplayMode'));
        }

        if ($collection->has('addFriendsMode')) {
            $updater->setAddFriendsMode($collection->get('addFriendsMode'));
        }

        if ($collection->has('messageWritingMode')) {
            $updater->setMessageWritingMode($collection->get('messageWritingMode'));
        }

        return $updater->update();
    }
}
