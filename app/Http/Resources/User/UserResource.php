<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Http\Resources\PrivacySetting\PrivacySettingResource;
use App\Http\Resources\Role\RoleCollection;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin User
 */
class UserResource extends BaseResource
{
    private Collection|null $additionalData;

    public function __construct(Model|JsonResource $resource, Collection $additionalData = null)
    {
        parent::__construct($resource);

        $this->additionalData = $additionalData;
    }

    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'email' => "string",
        'avatar' => "string",
        'friendsCount' => "int",
        'postsCount' => "int",
        'isMyFriend' => "bool",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'roles' => "RoleCollection",
        'privacySettings' => "PrivacySettingResource",
        'friends' => "UserCollection",
    ])]
    public function toArray($request): array
    {
        $isMyFriend = false;

        if ($this->id !== $this->authUser->id) {
            if ($this->additionalData) {
                if ($this->additionalData->has('isMyFriendsIDs')) {
                    $isMyFriend = in_array($this->id, $this->additionalData->get('isMyFriendsIDs'));
                }
            } else {
                $isMyFriend = $this->authUser->hasFriend($this->resource);
            }
        }

        $collection = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar === 'core/user.svg'
                ? Storage::disk('public')->url($this->avatar)
                : Storage::disk('users')->url($this->avatar),
            'friendsCount' => $this->friends_count ?? 0,
            'postsCount' => $this->posts_count ?? 0,
            'isMyFriend' => $isMyFriend,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        if ($this->relationLoaded('roles')) {
            $collection['roles'] = $this->roles
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
