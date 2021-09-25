<?php

namespace App\Observers;

use App\Models\User\User;
use App\Services\User\PrivacySettingService;

class UserObserver
{
    public bool $afterCommit = true;

    public function created(User $user): void
    {
        $user->setUserRole();

        (new PrivacySettingService())->create(
            collect([
                'profileDisplayMode' => 1,
                'addFriendsMode' => 1,
                'messageWritingMode' => 1,
            ]),
            $user
        );
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
