<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;
use App\Services\CommentService;
use JetBrains\PhpStorm\ArrayShape;

class CommentStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'id' => "array",
        'type' => "array",
        'text' => "string"
    ])]
    public function rules(): array
    {
        $service = new CommentService();
        $type = $this->post('type');

        return [
            'id' => [
                'required',
                'numeric',
                "exists:" . $service::MODELS[$type]
            ],
            'type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($service) {
                    if (!$service->isCommentableModel($value)) {
                        $fail('The :attribute is invalid.');
                    }
                }
            ],
            'text' => [
                'required',
                'string',
                'max:5000'
            ]
        ];
    }
}
