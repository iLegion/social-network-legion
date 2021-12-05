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
        'byLikes' => "array",
        'byViews' => "array"
    ])]
    public function rules(): array
    {
        return [
            'userId' => [
                'sometimes',
                'required',
                Rule::exists(User::class, 'id')
            ],
            'byLikes' => [
                'sometimes',
                'required',
                'bool'
            ],
            'byViews' => [
                'sometimes',
                'required',
                'bool'
            ]
        ];
    }
}
