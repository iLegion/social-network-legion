<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author->id;
    }

    public function destroy(User $user, Post $post): bool
    {
        return $user->id === $post->author->id || $user->isAdmin();
    }
}
