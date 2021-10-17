<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Exception;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function __invoke(RegisterRequest $request, UserService $service): UserResource
    {
        DB::beginTransaction();

        try {
            $user = $service->create(collect($request->validated()));

            DB::commit();

            return new UserResource($user);
        } catch (Exception $e) {
            DB::rollBack();

            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
