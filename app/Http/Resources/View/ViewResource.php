<?php

namespace App\Http\Resources\View;

use App\Http\Resources\BaseResource;
use App\Http\Resources\User\UserResource;
use App\Models\View;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin View
 */
class ViewResource extends BaseResource
{
    #[Pure]
    #[ArrayShape([
        'id' => "int",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'user' => "\App\Http\Resources\User\UserResource"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'user' => new UserResource($this->user)
        ];
    }
}
