<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share admin WhatsApp number across all user views
        View::composer('user.*', function ($view) {
            $adminPhoneRaw = User::where('role', 'admin')->value('nomor_telepon');
            $adminWhatsapp = null;

            if ($adminPhoneRaw) {
                $digits = preg_replace('/\D+/', '', $adminPhoneRaw);
                if (str_starts_with($digits, '0')) {
                    $digits = '62' . substr($digits, 1);
                } elseif (! str_starts_with($digits, '62')) {
                    $digits = '62' . $digits;
                }
                $adminWhatsapp = $digits;
            }

            $view->with('adminWhatsapp', $adminWhatsapp);
        });
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        Response::macro('ok', function ($massage, $data = []) {
            return Response::json([
                'meta' => [
                    'status_code' => 200,
                    'success' => true,
                    'message' => $massage
                ],
                'data' => $data
            ], 200);
        });

        Response::macro('created', function ($massage, $data = []) {
            if (count($data)) {
                return Response::json([
                    'meta' => [
                        'status_code' => 201,
                        'success' => true,
                        "message" => $massage
                    ],
                    'data' => $data
                ], 201);
            }

            return Response::json([], 201);
        });

        Response::macro('noContent', function ($data = []) {
            return Response::json([], 204);
        });

        Response::macro('badRequest', function ($message = 'Validation Failure', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 400);
        });

        Response::macro('unauthorized', function ($message = 'User unauthorized', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 401);
        });

        Response::macro('forbidden', function ($message = 'Access denied', $errors = []) use ($instance) {
            dd($message);
            exit();
            return $instance->handleErrorResponse($message, $errors, 403);
        });

        Response::macro('notFound', function ($message = 'Resource not found.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 404);
        });

        Response::macro('internalServerError', function ($message = 'Internal Server Error.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 500);
        });

        Response::macro('serviceUnavailable', function ($message = 'Service Unavailable.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 503);
        });

        Response::macro('validationFailed', function ($errors) {
            return Response::json([
                'meta' => [
                    'status_code' => 422,
                    'success' => false,
                    "message" => 'Validation failed'
                ],
                'errors' => $errors
            ], 422);
        });
        Response::macro('deleted', function ($message = 'Resource deleted successfully') {
            return Response::json([
                'meta' => [
                    'status_code' => 200,
                    'success' => true,
                    'message' => $message
                ]
            ], 200);
        });
    }

    public function handleErrorResponse($message, $errors, $status)
    {
        $response = [
            'meta' => [
                'status_code' => $status,
                'success' => false,
                'message' => $message
            ]
        ];

        if (!empty($errors)) {
            $response['meta']['errors'] = $errors;
        }

        return Response::json($response, $status);
    }
}
