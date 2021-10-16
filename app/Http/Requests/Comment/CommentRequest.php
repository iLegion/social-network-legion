<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\BaseRequest;
use App\Services\CommentService;
use JetBrains\PhpStorm\ArrayShape;

class CommentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'id' => "array",
        'type' => "array"
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
            ]
        ];
    }
}
