<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ReaderCannotAccessCategoriesException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'Reader cannot access categories'
        ], 403);
    }
}
