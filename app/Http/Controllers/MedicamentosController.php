<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicamentosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todos = DB::table('cuadro_basico')->orderBy('nombre_medicamento')->get();
        $controlados = DB::table('cuadro_basico')->where('es_controlado', 1)->orderBy('nombre_medicamento')->get();
        $no_controlados = DB::table('cuadro_basico')->where('es_controlado', 0)->orderBy('nombre_medicamento')->get();
        $nivel_a = DB::table('cuadro_basico')->where('requiere_nivel_minimo', 'A')->get();
        $nivel_b = DB::table('cuadro_basico')->where('requiere_nivel_minimo', 'B')->get();
        $nivel_c = DB::table('cuadro_basico')->where('requiere_nivel_minimo', 'C')->get();
        $total = count($todos);
        $total_controlados = count($controlados);

        return view('niveles.medicamentos', compact(
            'user', 'todos', 'controlados', 'no_controlados',
            'nivel_a', 'nivel_b', 'nivel_c', 'total', 'total_controlados'
        ));
    }
}
