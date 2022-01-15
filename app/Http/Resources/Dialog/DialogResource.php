<?php

namespace App\Http\Resources\Dialog;

use App\Http\Resources\BaseResource;
use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Dialog
 */
class DialogResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'title' => "string",
        'lastMessage' => "string",
        'unreadCount' => "int",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon",
        'lastMessageCreatedAt' => "\Illuminate\Support\Carbon",
        'lastMessageUpdatedAt' => "\Illuminate\Support\Carbon",
    ])]
    public function toArray($request): array
    {
        /** @var DialogMessage $lastMessage */
        $lastMessage = $this->messages()->latest()->first(['text', 'created_at', 'updated_at']);
        $unreadCount = $this->messages()->unread()->count();
        $title = $this->users()->count() === 2
            ? $this->users()->where('id', '!=', $this->authUser->id)->first()->name
            : $this->title;

        return [
            'id' => $this->id,
            'title' => $title,
            'unreadCount' => $unreadCount,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'lastMessage' => $lastMessage->text,
            'lastMessageCreatedAt' => $lastMessage->created_at,
            'lastMessageUpdatedAt' => $lastMessage->updated_at,
        ];
    }
}
