<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = $this->user;

        $user->tokens()
            ->where(
                'id',
                $user->currentAccessToken()->id
            )->delete();

        return response()->json([], 204);
    }
}
