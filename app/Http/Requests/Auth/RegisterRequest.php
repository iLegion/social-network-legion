<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends BaseRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:32'],
        ];
    }
}
