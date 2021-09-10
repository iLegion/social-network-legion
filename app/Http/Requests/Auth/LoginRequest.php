<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'email' => "string[]",
        'password' => "array"
    ])]
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!auth()->attempt($this->only(['email', 'password']))) {
                        $fail('The :attribute is invalid.');
                    }
                }
            ],
        ];
    }
}
