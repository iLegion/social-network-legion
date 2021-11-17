<?php

namespace App\Http\Resources\Dialog;

use App\Http\Resources\BaseCollection;

class DialogCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
