<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\BaseCollection;

class RoleCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
