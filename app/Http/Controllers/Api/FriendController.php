<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class FriendController extends Controller
{
    /**
     * @throws AuthorizationException|InternalServerErrorException
     */
    public function getMyFriends(): UserCollection
    {
        $this->authorize('getMyFriends', User::class);

        try {
            return new UserCollection(
                $this->user
                    ->friends()
                    ->paginate(30)
            );
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException|InternalServerErrorException
     */
    public function getFriends(User $user): UserCollection
    {
        $this->authorize('getFriends', $user);

        try {
            return new UserCollection(
                $user->friends()
                    ->paginate(30)
            );
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
