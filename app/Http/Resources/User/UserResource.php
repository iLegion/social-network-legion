<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Http\Resources\PrivacySetting\PrivacySettingResource;
use App\Http\Resources\Role\RoleCollection;
use App\Models\User\User;
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
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'roles' => "RoleCollection",
        'privacySettings' => "PrivacySettingResource",
    ])]
    public function toArray($request): array
    {
        $collection = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];

        if ($this->relationLoaded('roles')) {
            $collection['roles'] = $this->roles()->count()
                ? new RoleCollection($this->roles, false)
                : [];
        }

        if ($this->relationLoaded('privacySettings')) {
            $collection['privacySettings'] = $this->privacySettings
                ? new PrivacySettingResource($this->privacySettings)
                : null;
        }

        return $collection;
    }
}
