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
    ])]
    public function toArray($request): array
    {
        /** @var DialogMessage $lastMessage */
        $lastMessage = $this->messages()->latest()->first('text');
        $unreadCount = $this->messages()->unread()->count();
        $formattedLastMessage = $lastMessage
            ? mb_substr($lastMessage->text, 0, 150)
            : '';
        $title = $this->users()->count() === 2
            ? $this->users()->where('id', '!=', $this->user->id)->first()->name
            : $this->title;

        return [
            'id' => $this->id,
            'title' => $title,
            'lastMessage' => $formattedLastMessage,
            'unreadCount' => $unreadCount,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
