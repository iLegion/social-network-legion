<?php

namespace App\Traits\Policies\User;

use App\Models\User\User;

trait UserPolicyTrait
{
    public function index(): bool
    {
        return true;
    }

    public function me(): bool
    {
        return true;
    }

    public function show(User $user, User $model): bool
    {
        return true;
//        return $user->id === $model->id || $user->hasFriend($model) || $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
