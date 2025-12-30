<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserOnboardedWeb
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (
            $user &&
            $user->role === 'user' &&
            ! $user->onboarded
        ) {
            return redirect()->route('user.onboarding');
        }

        return $next($request);
    }
}
