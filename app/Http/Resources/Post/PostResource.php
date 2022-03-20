<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\BaseResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Post
 */
class PostResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'image' => "string",
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
            'image' => Storage::disk('posts')->url($this->image),
            'title' => $this->title,
            'text' => $this->text,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'author' => new SimpleUserResource($this->author),
            'viewsCount' => $this->views_count ?? 0,
            'likesCount' => $this->likes_count ?? 0,
            'commentsCount' => $this->comments_count ?? 0,
        ];
    }
}
