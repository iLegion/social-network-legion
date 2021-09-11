<?php

namespace App\Traits\Policies\User;

use App\Models\User;

trait UserPolicyTrait
{
    public function me(): bool
    {
        return true;
    }

    public function show(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}