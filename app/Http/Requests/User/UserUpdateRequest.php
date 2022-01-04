<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'name' => "string[]",
        'email' => "string[]",
        'password' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'email',
                'unique:users'
            ],
            'password' => [
                'sometimes',
                'required',
                'string',
                'min:6',
                'max:32'
            ]
        ];
    }
}
