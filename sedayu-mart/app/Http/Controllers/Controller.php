<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    public function exceptionError(
        \Throwable $e,
        string $exception,
        int $status = 400
    ) {
        $request = request();

        /**
         * Skip log validation error
         */
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        }

        /**
         * Log ke file (SELALU)
         */
        Log::error($exception, [
            'user_id' => optional($request->user())->id,
            'method'  => $request->method(),
            'url'     => $request->fullUrl(),
            'message' => $e->getMessage(),
            'trace'   => app()->isProduction() ? null : $e->getTraceAsString(),
            'payload' => $request->all(),
        ]);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'errors' => 'Exception Error : ' . $exception,
        ], $status);
    }


    public function successResponse($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }


    public function respond($data)
    {
        return response()->json($data);
    }
}
