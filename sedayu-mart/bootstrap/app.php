<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\EnsureUserOnboardedApi;
use App\Http\Middleware\EnsureUserOnboardedWeb;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )


    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware
        $middleware->alias([
            // Register RoleMiddleware
            'role' => RoleMiddleware::class,

            // Register EnsureUserOnboarded middleware
            'onboarded.web' => EnsureUserOnboardedWeb::class,
            'onboarded.api' => EnsureUserOnboardedApi::class,
        ]);

        // Apply middleware to API group
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
            SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Unauthenticated (belum login / token tidak ada / token invalid)
        $exceptions->render(function (AuthenticationException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                    'errors' => 'Token tidak valid atau belum login',
                ], 401);
            }
        });

        // Unauthorized (login tapi tidak punya akses)
        $exceptions->render(function (AuthorizationException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                    'errors' => 'Anda tidak memiliki akses',
                ], 403);
            }
        });
    })->create();
