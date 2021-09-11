<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin User
 */
class UserResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'email' => "string",
        'created_at' => "\Carbon\Carbon",
        'updated_at' => "\Carbon\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
