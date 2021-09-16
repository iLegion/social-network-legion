<?php

namespace App\Services\Post;

use App\Aggregators\Post\PostQueryBuilderAggregator;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
    public function getPostsForIndexPage(): Builder
    {
        return (new PostQueryBuilderAggregator(['author']))
            ->getBuilder();
    }
}
