<?php

namespace App\Http\Resources\DialogMessage;

use App\Http\Resources\BaseCollection;

class DialogMessageCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
    }
}
