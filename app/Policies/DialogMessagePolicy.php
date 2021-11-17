<?php

namespace App\Policies;

use App\Models\Dialog\DialogMessage;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DialogMessagePolicy
{
    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return true;
    }
}
