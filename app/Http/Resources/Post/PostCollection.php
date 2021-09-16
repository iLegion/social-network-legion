<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\BaseCollection;
use JetBrains\PhpStorm\Pure;

class PostCollection extends BaseCollection
{
    #[Pure]
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
