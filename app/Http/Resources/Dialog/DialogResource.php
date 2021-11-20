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
        $formattedLastMessage = $lastMessage
            ? mb_substr($lastMessage->text, 0, 150)
            : '';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'lastMessage' => $formattedLastMessage,
            'unreadCount' => 0,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
