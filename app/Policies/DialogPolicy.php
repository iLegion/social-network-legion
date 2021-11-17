<?php

namespace App\Policies;

use App\Models\Dialog\Dialog;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DialogPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Dialog $dialog): bool
    {
        return $user->id === $dialog->owner_id;
    }
}
