<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\CuadroBasico;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $logsHoy = AuditLog::whereDate('created_at', now())->count();
        $medicamentos = CuadroBasico::count();

        return view('dashboard', compact('totalUsuarios', 'logsHoy', 'medicamentos'));
    }
}