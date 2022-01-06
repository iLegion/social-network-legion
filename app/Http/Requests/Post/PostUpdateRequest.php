<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class PostUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'title' => "string[]",
        'text' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'text' => [
                'sometimes',
                'required',
                'array'
            ]
        ];
    }
}
