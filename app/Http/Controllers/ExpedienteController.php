<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    private function esSuperAdmin()
    {
        return DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', Auth::id())
            ->where('roles.name', 'SuperAdmin')
            ->exists();
    }

    public function listar()
    {
        $user = Auth::user();
        
        if ($this->esSuperAdmin()) {
            $expedientes = DB::table('expedientes')->orderBy('created_at', 'desc')->get();
        } else {
            $expedientes = DB::table('expedientes')->where('doctor_id', $user->id)->orderBy('created_at', 'desc')->get();
        }
        
        return view('niveles.expedientes', compact('user', 'expedientes'));
    }

    public function ver($expediente_id)
    {
        $expediente = DB::table('expedientes')->where('id', $expediente_id)->first();
        if (!$expediente) return back()->with('error', 'Expediente no encontrado');

        $notas = DB::table('notas_expediente')
            ->where('expediente_id', $expediente_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $recetas = DB::table('recetas')
            ->join('receta_items', 'recetas.id', '=', 'receta_items.receta_id')
            ->where('recetas.paciente_nombre', $expediente->paciente_nombre)
            ->select('recetas.*', 'receta_items.medicamento', 'receta_items.cantidad')
            ->orderBy('recetas.created_at', 'desc')
            ->get();

        $esAdmin = $this->esSuperAdmin();

        return view('niveles.ver_expediente', compact('expediente', 'notas', 'recetas', 'esAdmin'));
    }

    public function agregarNota(Request $request, $expediente_id)
    {
        $request->validate([
            'tipo_nota' => 'required',
            'nota_clinica' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
        ]);

        DB::table('notas_expediente')->insert([
            'expediente_id' => $expediente_id,
            'doctor_id' => Auth::id(),
            'doctor_nombre' => Auth::user()->name,
            'tipo_nota' => $request->tipo_nota,
            'signos_vitales' => json_encode([
                'ta' => $request->ta,
                'fc' => $request->fc,
                'temp' => $request->temp,
                'spo2' => $request->spo2,
            ]),
            'nota_clinica' => $request->nota_clinica,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Nota agregada al expediente');
    }

    public function crearExpediente()
    {
        $user = Auth::user();
        $siguiente = DB::table('expedientes')->count() + 1;
        $num_exp = 'EXP-2026-' . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
        return view('niveles.crear_expediente', compact('user', 'num_exp'));
    }

    public function guardarExpediente(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required',
            'num_expediente' => 'required|unique:expedientes,num_expediente',
        ]);

        DB::table('expedientes')->insert([
            'paciente_nombre' => $request->paciente_nombre,
            'paciente_curp' => $request->paciente_curp,
            'paciente_fecha_nacimiento' => $request->paciente_fecha_nacimiento,
            'paciente_genero' => $request->paciente_genero,
            'paciente_alergias' => $request->paciente_alergias,
            'paciente_antecedentes' => $request->paciente_antecedentes,
            'doctor_id' => Auth::id(),
            'doctor_nombre' => Auth::user()->name,
            'num_expediente' => $request->num_expediente,
            'created_at' => now(),
        ]);

        return redirect('/expedientes')->with('success', 'Expediente creado');
    }
}
