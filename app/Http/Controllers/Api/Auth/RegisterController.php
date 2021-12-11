<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function __invoke(RegisterRequest $request, UserService $service): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = $service->create(collect($request->validated()));

            DB::commit();

            return response()->json([
                'data' => [
                    'type' => 'Bearer',
                    'token' => $user->createToken('authToken')->plainTextToken
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
