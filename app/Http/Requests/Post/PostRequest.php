<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use App\Models\User\User;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class PostRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'userId' => "array",
        'byLikesCount' => "string[]",
        'byViewsCount' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'userId' => [
                'sometimes',
                'required',
                Rule::exists(User::class, 'id')
            ],
            'byLikesCount' => [
                'sometimes',
                'required',
                'bool'
            ],
            'byViewsCount' => [
                'sometimes',
                'required',
                'bool'
            ]
        ];
    }
}
