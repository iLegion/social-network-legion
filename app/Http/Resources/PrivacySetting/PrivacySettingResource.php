<?php

namespace App\Http\Resources\PrivacySetting;

use App\Http\Resources\BaseResource;
use App\Models\User\PrivacySetting;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin PrivacySetting
 */
class PrivacySettingResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'profileDisplayMode' => "int",
        'addFriendsMode' => "int",
        'messageWritingMode' => "int",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'profileDisplayMode' => $this->profile_display_mode,
            'addFriendsMode' => $this->add_friends_mode,
            'messageWritingMode' => $this->message_writing_mode,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
