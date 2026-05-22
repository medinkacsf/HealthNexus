<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $tieneAdmin = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $userId)
                ->where('roles.name', 'SuperAdmin')
                ->exists();

            if (!$tieneAdmin) {
                abort(403, 'ACCESO DENEGADO: No tienes permisos de Super Administrador.');
            }
        }

        return $next($request);
    }
}
