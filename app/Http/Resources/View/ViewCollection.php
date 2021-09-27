<?php

namespace App\Http\Resources\View;

use App\Http\Resources\BaseCollection;

class ViewCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
