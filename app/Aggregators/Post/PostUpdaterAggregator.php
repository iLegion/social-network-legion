<?php

namespace App\Aggregators\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostUpdaterAggregator
{
    private Post $builder;

    public function __construct(Post $post)
    {
        $this->builder = $post;
    }

    public function setImage(UploadedFile $value): static
    {
        $image = $this->builder->image;
        $path = Storage::disk('posts')->putFile('/' . $this->builder->id . '/images', $value);

        Storage::disk('users')->delete($image);

        $this->builder->image = $path;

        return $this;
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
