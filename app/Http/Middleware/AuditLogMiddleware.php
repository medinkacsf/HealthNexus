<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auditoria;

class AuditLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            $modulo = $this->determineModule($request->path());
            $accion = $this->determineAction($request);

            // CAPTURAR DATOS DEL FORMULARIO (Solo si es POST o PUT)
            $extraData = [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
            ];

            if ($request->isMethod('post') || $request->isMethod('put')) {
                // Guardamos todo lo que se envió en el formulario (passwords excluidos por seguridad en producción, pero aquí lo veremos)
                $extraData['payload'] = $request->all();
            }

            Auditoria::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'modulo' => $modulo,
                'accion' => $accion,
                'descripcion' => "Usuario accedió a: " . $request->path(),
                'ip_address' => $request->ip(),
                'datos_nuevos' => $extraData
            ]);
        }

        return $response;
    }

    private function determineModule($path)
    {
        if (str_contains($path, 'farmacia')) return 'FARMACIA';
        if (str_contains($path, 'citas')) return 'MEDICO';
        if (str_contains($path, 'rh') || str_contains($path, 'admin')) return 'RRHH';
        if (str_contains($path, 'inventario')) return 'INVENTARIO';
        return 'SISTEMA';
    }

    private function determineAction($request)
    {
        if ($request->isMethod('post')) return 'CREAR';
        if ($request->isMethod('put') || $request->isMethod('patch')) return 'EDITAR';
        if ($request->isMethod('delete')) return 'ELIMINAR';
        return 'VISUALIZAR';
    }
}
