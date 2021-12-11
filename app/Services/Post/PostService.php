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
    public function get(Collection $collection, User $user): Builder
    {
        $aggregator = (new PostQueryBuilderAggregator(['author'], ['likes', 'views']));

        if ($collection->has('user')) {
            $aggregator->byAuthor($collection->get('user'));
        } else {
            $aggregator->byNotAuthor($user);
        }

        if ($collection->get('byLikes')) {
            $aggregator->byLikes();
        }

        if ($collection->get('byViews')) {
            $aggregator->byViews();
        }

        if (!($collection->get('byLikes') || $collection->get('byViews'))) {
            $aggregator->byLatest();
        }

        return $aggregator->getBuilder();
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
