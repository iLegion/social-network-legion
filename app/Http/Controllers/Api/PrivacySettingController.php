<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrivacySetting\PrivacySettingUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User\PrivacySetting;
use App\Services\User\PrivacySettingService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class PrivacySettingController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function update(PrivacySettingUpdateRequest $request, PrivacySetting $privacySetting): UserResource
    {
        $this->authorize('update', $privacySetting);

        try {
            $privacySetting = (new PrivacySettingService())
                ->update(collect($request->validated()), $privacySetting);
            $user = $privacySetting->user;

            return new UserResource(
                $user
                ->loadCount(['posts', 'friends'])
                ->load(['roles'])
            );
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
