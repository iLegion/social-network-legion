<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
