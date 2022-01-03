<?php

namespace App\Http\Requests\Dialog;

use App\Http\Requests\BaseRequest;
use App\Models\User\User;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class DialogStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'title' => "string[]",
        'userID' => "string",
    ])]
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string'
            ],
            'userID' => [
                'required',
                'numeric',
                'exists:users,id'
            ]
        ];
    }
}
