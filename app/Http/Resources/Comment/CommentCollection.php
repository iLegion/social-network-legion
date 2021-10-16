<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\BaseCollection;

class CommentCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
