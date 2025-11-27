<?php

namespace App\Http\Middleware\Auth;

use App\Enums\User\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $in_scope_role = in_array($user?->role, RoleEnum::client_user());
        if (!$user || !$in_scope_role) {
            return redirect()->route('homepage.index');
        }
        return $next($request);
    }
}
