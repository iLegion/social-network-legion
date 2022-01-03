<?php

namespace App\Traits\Policies\User;

use App\Models\User\User;

trait DialogPolicyTrait
{
    public function storeDialog(User $user, User $model): bool
    {
        return $user->id !== $model->id && ($model->privacySettings->message_writing_mode || $user->hasFriend($model));
    }
}
