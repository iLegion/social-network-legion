<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where(
            'email',
            $request->input('email')
        )->first();

        DB::beginTransaction();

        try {
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
