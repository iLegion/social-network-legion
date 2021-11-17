<?php

namespace App\Http\Resources\Dialog;

use App\Http\Resources\BaseResource;
use App\Models\Dialog\Dialog;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Dialog
 */
class DialogResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'title' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updateAt' => "\Illuminate\Support\Carbon",
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'createdAt' => $this->created_at,
            'updateAt' => $this->updated_at
        ];
    }
}
