<?php

namespace App\Http\Resources\DialogMessage;

use App\Http\Resources\BaseResource;
use App\Models\Dialog\DialogMessage;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin DialogMessage
 */
class DialogMessageResource extends BaseResource
{
    #[ArrayShape([
        'id' => "int",
        'dialogId' => "int",
        'text' => "string",
        'userName' => "string",
        'readAt' => "\Illuminate\Support\Carbon",
        'createdAt' => "\Illuminate\Support\Carbon",
        'updatedAt' => "\Illuminate\Support\Carbon"
    ])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'dialogId' => $this->dialog_id,
            'text' => $this->text,
            'userName' => $this->user->name,
            'readAt' => $this->read_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
