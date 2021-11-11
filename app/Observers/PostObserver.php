<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\LikeService;
use App\Services\LoggerService;
use App\Services\ViewService;
use Exception;

class PostObserver
{
    public bool $afterCommit = true;

    public function created(Post $post)
    {
        //
    }

    public function updated(Post $post)
    {
        //
    }

    public function deleted(Post $post)
    {
        try {
            (new LikeService())->delete($post, $post->author);
            (new ViewService())->delete($post, $post->author);
        } catch (Exception $e) {
            app(LoggerService::class)->info(
                Post::class,
                $e->getMessage(),
                ['trace' => $e->getTrace()]
            );
        }
    }

    public function restored(Post $post)
    {
        //
    }

    public function forceDeleted(Post $post)
    {
        //
    }
}
