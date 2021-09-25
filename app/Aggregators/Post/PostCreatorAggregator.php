<?php

namespace App\Aggregators\Post;

use App\Models\Post;
use App\Models\User\User;

class PostCreatorAggregator
{
    private Post $builder;

    public function __construct()
    {
        $this->builder = new Post();
    }

    public function setTitle(string $value): static
    {
        $this->builder->title = $value;

        return $this;
    }

    public function setText(?string $value): static
    {
        $this->builder->text = $value;

        return $this;
    }

    public function setAuthor(User $user): static
    {
        $this->builder->author()->associate($user);

        return $this;
    }

    public function create(): Post
    {
        $this->builder->save();

        return $this->builder;
    }
}
