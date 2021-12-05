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
        $service = new LikeService();
        $id = $this->input('id');
        $type = $this->input('type');
        $model = $this->has('id') && $this->has('type') ? $service->getModel($id, $type) : null;

        return [
            'id' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (!$this->has('type')) {
                        $fail('The type not exists.');
                    }
                },
                function ($attribute, $value, $fail) use ($service, $model) {
                    if ($model && $service->isExists($model, $this->user())) {
                        $fail('The like is exists.');
                    }
                },
            ],
            'type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($service) {
                    if (!$service->isLikeableModel($value)) {
                        $fail('The :attribute is invalid.');
                    }
                }
            ]
        ];
    }
}
