<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseCollection;
use JetBrains\PhpStorm\Pure;

class UserCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
