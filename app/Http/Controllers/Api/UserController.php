<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function index(UserService $userService): UserCollection
    {
        $this->authorize('index', User::class);

        try {
            $users = $userService
                ->get()
                ->orderByDesc('id')
                ->where('id', '!=', $this->user->id)
                ->paginate(30);

            return new UserCollection($users);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function getMe(): UserResource
    {
        $this->authorize('me', User::class);

        try {
            return new UserResource(
                $this->user
                    ->loadCount(['posts', 'friends'])
                    ->load(['roles'])
            );
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function show(User $user): UserResource
    {
        $this->authorize('show', $user);

        try {
            return new UserResource(
                $user
                    ->loadCount(['posts', 'friends'])
                    ->load(['roles'])
            );
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function update(UserUpdateRequest $request, User $user, UserService $userService): UserResource
    {
        $this->authorize('update', $this->user);

        try {
            $user = $userService->update($user, collect($request->validated()));

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
