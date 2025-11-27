<?php

namespace App\Http\Middleware\Auth;

use App\Enums\User\RoleEnum;
use App\Services\Utils\Toast;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $in_scope_role = in_array($user?->role, RoleEnum::admin_user());
        if (!$user || !$in_scope_role) {
            Toast::info('Anda tidak dapat mengakses halaman tersebut.');
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
