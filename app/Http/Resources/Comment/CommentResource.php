<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\BaseResource;
use App\Http\Resources\User\UserResource;
use App\Models\Comment;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin Comment
 */
class CommentResource extends BaseResource
{
    #[Pure]
    #[ArrayShape([
        'id' => "int",
        'text' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'user' => "\App\Http\Resources\User\UserResource"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'user' => new UserResource($this->user)
        ];
    }
}
