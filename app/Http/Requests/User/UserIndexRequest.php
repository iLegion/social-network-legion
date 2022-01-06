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
        'postsCount' => "string[]",
        'friendsCount' => "string[]"
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
            'postsCount' => [
                'sometimes',
                'required',
                'bool'
            ],
            'friendsCount' => [
                'sometimes',
                'required',
                'bool'
            ]
        ];
    }
}
