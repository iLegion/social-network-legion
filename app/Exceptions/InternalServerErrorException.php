<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Throwable;

class InternalServerErrorException extends Exception
{
    #[Pure]
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'Internal Server Error.'
        ], 500);
    }
}
