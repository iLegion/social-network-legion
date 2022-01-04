<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserUpdateAvatarRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'file' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:jpg,png',
                'max:15000'
            ]
        ];
    }
}
