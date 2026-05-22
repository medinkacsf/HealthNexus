<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectByRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userId = Auth::id();
        $rol = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', $userId)
            ->value('roles.name');

        $ruta = $request->path();

        // SuperAdmin puede ir a todo
        if ($rol === 'SuperAdmin') {
            return $next($request);
        }

        // Rutas permitidas para cada rol
        $permisos = [
            'Nivel_A' => ['/nivel-a', '/expedientes', '/expediente/', '/receta/crear', '/receta/guardar', '/logout'],
            'Nivel_B' => ['/nivel-b', '/expedientes', '/expediente/', '/logout'],
            'Nivel_C' => ['/nivel-c', '/expedientes', '/expediente/', '/logout'],
            'Farmacia' => ['/farmacia', '/receta/ver/', '/farmacia/despachar/', '/logout'],
            'Enfermeria' => ['/enfermeria', '/logout'],
            'Gobierno' => ['/gobierno', '/logout'],
            'RH' => ['/rh', '/logout'],
        ];

        // Login y dashboard son públicos para autenticados
        $publicas = ['/login', '/dashboard', '/logout', '/ia/'];
        foreach ($publicas as $pub) {
            if (str_starts_with($ruta, $pub)) {
                return $next($request);
            }
        }

        // Verificar permisos
        if (isset($permisos[$rol])) {
            foreach ($permisos[$rol] as $permitida) {
                if (str_starts_with($ruta, $permitida)) {
                    return $next($request);
                }
            }
        }

        // Redirigir al dashboard de su rol
        $dashboards = [
            'Nivel_A' => '/nivel-a',
            'Nivel_B' => '/nivel-b',
            'Nivel_C' => '/nivel-c',
            'Farmacia' => '/farmacia',
            'Enfermeria' => '/enfermeria',
            'Gobierno' => '/gobierno',
            'RH' => '/rh',
        ];

        $destino = $dashboards[$rol] ?? '/dashboard';
        abort(403, 'ACCESO DENEGADO: No tienes permiso para acceder aqui.');
    }
}
