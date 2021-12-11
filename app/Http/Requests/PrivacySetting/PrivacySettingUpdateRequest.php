<?php

namespace App\Http\Requests\PrivacySetting;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class PrivacySettingUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'profileDisplayMode' => "array",
        'addFriendsMode' => "array",
        'messageWritingMode' => "array"
    ])]
    public function rules(): array
    {
        return [
            'profileDisplayMode' => [
                'sometimes',
                'required',
                'numeric',
                Rule::in([0, 1])
            ],
            'addFriendsMode' => [
                'sometimes',
                'required',
                'numeric',
                Rule::in([0, 1])
            ],
            'messageWritingMode' => [
                'sometimes',
                'required',
                'numeric',
                Rule::in([0, 1])
            ]
        ];
    }
}
