<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseCollection;
use JetBrains\PhpStorm\Pure;

class UserCollection extends BaseCollection
{
    #[Pure]
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
