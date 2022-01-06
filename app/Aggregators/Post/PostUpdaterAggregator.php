<?php

namespace App\Aggregators\Post;

use App\Models\Post;

class PostUpdaterAggregator
{
    private Post $builder;

    public function __construct(Post $post)
    {
        $this->builder = $post;
    }

    public function setTitle(string $value): static
    {
        $this->builder->title = $value;

        return $this;
    }

    public function setText(array $value): static
    {
        $this->builder->text = $value;

        return $this;
    }

    public function update(): Post
    {
        $this->builder->save();

        return $this->builder;
    }
}
