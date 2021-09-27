<?php

namespace App\Http\Requests\View;

use App\Http\Requests\BaseRequest;
use App\Services\ViewService;
use JetBrains\PhpStorm\ArrayShape;

class ViewStoreRequest extends BaseRequest
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
        $viewService = new ViewService();
        $id = $this->post('id');
        $type = $this->post('type');
        $model = $viewService->getModel($id, $type);

        return [
            'id' => [
                'required',
                'numeric',
                "exists:" . $viewService::MODELS[$type],
                function ($attribute, $value, $fail) use ($viewService, $model) {
                    if ($viewService->isExists($model, $this->user())) {
                        $fail('The view is exists.');
                    }
                }
            ],
            'type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($viewService) {
                    if (!$viewService->isViewableModel($value)) {
                        $fail('The :attribute is invalid.');
                    }
                }
            ]
        ];
    }
}
