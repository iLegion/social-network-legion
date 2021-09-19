<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\BaseResource;
use App\Models\Role;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Role
 */
class RoleResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'title' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
