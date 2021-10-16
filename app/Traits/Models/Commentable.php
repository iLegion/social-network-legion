<?php

namespace App\Traits\Models;

use App\Models\Comment;
use App\Models\User\User;
use App\Services\CommentService;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function addComment(User $user, string $text): void
    {
        (new CommentService())->create($this, $user, $text);
    }

    /**
     * @throws Exception
     */
    public function updateComment(User $user, string $text): void
    {
//        (new CommentService())->update($this, $user, $text);
    }

    /**
     * @throws Exception
     */
    public function deleteComment(User $user): void
    {
        (new CommentService())->delete($this, $user);
    }
}
