<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    /**
     * @throws AuthorizationException|InternalServerErrorException
     */
    public function me(): UserResource
    {
        $this->authorize('me', User::class);

        try {
            return new UserResource($this->user);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException|InternalServerErrorException
     */
    public function show(User $user): UserResource
    {
        $this->authorize('show', $user);

        try {
            return new UserResource($user);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
