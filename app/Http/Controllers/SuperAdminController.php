<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'usuarios' => DB::table('users')->count(),
            'expedientes' => DB::table('expedientes')->count(),
            'recetas_pendientes' => DB::table('recetas')->where('estado', 'pendiente_farmacia')->count(),
            'alertas_stock' => DB::table('inventario_farmacia')->whereColumn('stock_actual', '<=', 'stock_minimo')->count(),
            'logins_hoy' => DB::table('audit_logs')->whereDate('created_at', now())->where('tipo', 'login')->count(),
            'logins_fallidos' => DB::table('audit_logs')->whereDate('created_at', now())->where('tipo', 'login_fallido')->count(),
            'notas_pendientes' => DB::table('notas_medicas')->where('estado', 'pendiente_firma_a')->count(),
            'recetas_total' => DB::table('recetas')->count(),
        ];

        return view('superadmin.dashboard', compact('user', 'stats'));
    }
}
