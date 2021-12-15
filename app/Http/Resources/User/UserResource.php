<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Http\Resources\PrivacySetting\PrivacySettingResource;
use App\Http\Resources\Role\RoleCollection;
use App\Models\User\User;
use Illuminate\Support\Facades\Storage;
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
        'avatar' => "string",
        'friendsCount' => "int",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'roles' => "RoleCollection",
        'privacySettings' => "PrivacySettingResource",
    ])]
    public function toArray($request): array
    {
        $isMyFriend = $this->user->hasFriend($this->resource);
        $hasDialogWithMe = $this->user
            ->dialogs()
            ->whereHas('users', function ($builder) {
                $builder->where('user_id', $this->id);
            })->exists();
        $collection = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => Storage::disk('public')->url($this->avatar),
            'friendsCount' => $this->friends_count ?? 0,
            'postsCount' => $this->posts_count ?? 0,
            'isMyFriend' => $isMyFriend,
            'hasDialogWithMe' => $hasDialogWithMe,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
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

        if ($this->relationLoaded('friends')) {
            $collection['friends'] = $this->friends
                ? new UserCollection(
                    $this->friends()
                        ->withCount(['friends'])
                        ->paginate(30)
                )
                : null;
        }

        return $collection;
    }
}
