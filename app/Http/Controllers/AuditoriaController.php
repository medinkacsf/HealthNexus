<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('audit_logs')
            ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
            ->select('audit_logs.*', 'users.name as usuario_nombre', 'users.email as usuario_email');

        if ($request->filled('tipo')) {
            $query->where('audit_logs.tipo', $request->tipo);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('audit_logs.created_at', $request->fecha);
        }

        $logs = $query->orderBy('audit_logs.created_at', 'desc')->paginate(50);

        $resumen = [
            'total' => DB::table('audit_logs')->count(),
            'logins' => DB::table('audit_logs')->where('tipo', 'login')->count(),
            'logins_fallidos' => DB::table('audit_logs')->where('tipo', 'login_fallido')->count(),
            'registros' => DB::table('audit_logs')->where('tipo', 'registro')->count(),
            'hoy' => DB::table('audit_logs')->whereDate('created_at', now())->count(),
        ];

        return view('auditoria.index', compact('logs', 'resumen'));
    }
}
