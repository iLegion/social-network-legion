<?php

namespace App\Http\Requests\Like;

use App\Http\Requests\BaseRequest;
use App\Services\LikeService;
use JetBrains\PhpStorm\ArrayShape;

class LikeStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'id' => "string[]",
        'type' => "array"
    ])]
    public function rules(): array
    {
        $likeService = new LikeService();
        $id = $this->input('id');
        $type = $this->input('type');
        $model = $likeService->getModel($id, $type);

        return [
            'id' => [
                'required',
                'numeric',
                "exists:" . $likeService::MODELS[$type],
                function ($attribute, $value, $fail) use ($likeService, $model) {
                    if (!$likeService->isExists($model, $this->user())) {
                        $fail('The like not exists.');
                    }
                }
            ],
            'type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($likeService) {
                    if (!$likeService->isLikeableModel($value)) {
                        $fail('The :attribute is invalid.');
                    }
                }
            ]
        ];
    }
}
