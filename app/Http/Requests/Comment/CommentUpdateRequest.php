<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class CommentUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'text' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'text' => [
                'required',
                'string',
                'max:5000'
            ]
        ];
    }
}
