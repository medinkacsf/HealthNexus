<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $tieneAdmin = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', Auth::id())
            ->where('roles.name', 'SuperAdmin')
            ->exists();

        if (!$tieneAdmin) {
            abort(403, 'Acceso restringido al SuperAdministrador.');
        }
        return $next($request);
    }
}
