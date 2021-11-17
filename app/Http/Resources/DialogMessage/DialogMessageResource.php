<?php

namespace App\Http\Resources\DialogMessage;

use App\Http\Resources\BaseResource;
use App\Models\Dialog\DialogMessage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin DialogMessage
 */
class DialogMessageResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'text' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
