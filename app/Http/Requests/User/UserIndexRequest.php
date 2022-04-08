<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserIndexRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'name' => "string[]",
        'byPostsCount' => "string[]",
        'byFriendsCount' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:1',
                'max:255'
            ],
            'byPostsCount' => [
                'sometimes',
                'required',
                'bool'
            ],
            'byFriendsCount' => [
                'sometimes',
                'required',
                'bool'
            ]
        ];
    }
}
