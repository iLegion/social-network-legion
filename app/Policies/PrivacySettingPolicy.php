<?php

namespace App\Policies;

use App\Models\User\PrivacySetting;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrivacySettingPolicy
{
    use HandlesAuthorization;

    public function update(User $user, PrivacySetting $privacySetting): bool
    {
        return $privacySetting->user()->is($user);
    }
}
