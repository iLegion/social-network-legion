<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class PostStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'image' => "string[]",
        'title' => "string[]",
        'text' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'mimes:jpg,png'
            ],
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'text' => [
                'required',
                'array'
            ]
        ];
    }
}
