<?php

namespace App\Traits\Models;

use App\Models\Like;
use App\Models\User\User;
use App\Services\LikeService;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @throws Exception
     */
    public function addLike(User $user): void
    {
        (new LikeService())->create($this, $user);
    }

    /**
     * @throws Exception
     */
    public function deleteLike(User $user): void
    {
        (new LikeService())->delete($this, $user);
    }
}
