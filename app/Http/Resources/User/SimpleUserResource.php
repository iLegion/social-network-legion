<?php

namespace App\Http\Resources\User;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin User
 */
class SimpleUserResource extends JsonResource
{
    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'email' => "string",
        'avatar' => "string",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar === 'core/user.svg'
                ? Storage::disk('public')->url($this->avatar)
                : Storage::disk('users')->url($this->avatar),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
