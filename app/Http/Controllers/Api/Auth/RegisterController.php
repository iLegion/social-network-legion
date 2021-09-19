<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            User::query()->create(
                array_merge(
                    $request->only(['email', 'name']),
                    [
                        'password' => bcrypt($request->input('password'))
                    ]
                )
            );
            DB::commit();

            return response()->json([], 201);
        } catch (Exception $e) {
            DB::rollBack();

            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
