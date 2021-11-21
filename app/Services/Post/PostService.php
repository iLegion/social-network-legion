<?php

namespace App\Services\Post;

use App\Aggregators\Post\PostCreatorAggregator;
use App\Aggregators\Post\PostQueryBuilderAggregator;
use App\Aggregators\Post\PostUpdaterAggregator;
use App\Models\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostService
{
    public function getPostsForIndexPage(): Builder
    {
        return (new PostQueryBuilderAggregator(['author'], ['likes', 'views']))
            ->getBuilder();
    }

    public function create(Collection $collection, User $user): Post
    {
        return (new PostCreatorAggregator())
            ->setTitle($collection->get('title'))
            ->setText($collection->get('text'))
            ->setAuthor($user)
            ->create();
    }

    public function update(Post $post, Collection $collection): Post
    {
        $updater = new PostUpdaterAggregator($post);

        if ($collection->has('title')) {
            $updater = $updater->setTitle($collection->get('title'));
        }

        if ($collection->has('text')) {
            $updater = $updater->setText($collection->get('text'));
        }

        return $updater->update();
    }

    public function delete(Post $post): ?bool
    {
        return $post->delete();
    }
}
