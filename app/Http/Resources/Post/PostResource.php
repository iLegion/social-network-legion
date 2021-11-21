<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\BaseResource;
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin Post
 */
class PostResource extends BaseResource
{
    #[Pure]
    #[ArrayShape([
        'id' => "int",
        'title' => "string",
        'text' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'author' => "UserResource",
        'viewsCount' => "int",
        'likesCount' => "int",
        'commentsCount' => "int"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'author' => new UserResource($this->author),
            'viewsCount' => $this->views_count ?? 0,
            'likesCount' => $this->likes_count ?? 0,
            'commentsCount' => $this->comments_count ?? 0,
        ];
    }
}
