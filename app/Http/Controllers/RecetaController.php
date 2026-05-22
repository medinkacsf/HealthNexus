<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function crear()
    {
        $user = Auth::user();
        $medicamentos = DB::table('cuadro_basico')->orderBy('nombre_medicamento')->get();
        return view('niveles.crear_receta', compact('user', 'medicamentos'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required',
            'diagnostico' => 'required',
            'instrucciones' => 'required',
        ]);

        $receta_id = DB::table('recetas')->insertGetId([
            'paciente_nombre' => $request->paciente_nombre,
            'doctor_creador' => Auth::user()->name,
            'doctor_creador_id' => Auth::id(),
            'estado' => 'pendiente_firma_b',
            'diagnostico' => $request->diagnostico,
            'instrucciones' => $request->instrucciones,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $medicamentos = $request->input('medicamento', []);
        $cantidades = $request->input('cantidad', []);
        $instrucciones_uso = $request->input('instrucciones_uso', []);
        $niveles = $request->input('nivel', []);

        foreach ($medicamentos as $i => $med) {
            if (!empty($med) && !empty($cantidades[$i])) {
                DB::table('receta_items')->insert([
                    'receta_id' => $receta_id,
                    'medicamento' => $med,
                    'cantidad' => $cantidades[$i],
                    'instrucciones_uso' => $instrucciones_uso[$i] ?? '',
                    'requiere_nivel' => $niveles[$i] ?? 'C',
                ]);
            }
        }

        DB::table('notificaciones')->insert([
            'remitente_id' => Auth::id(),
            'destinatario_id' => 2,
            'titulo' => 'Nueva receta pendiente',
            'mensaje' => Auth::user()->name . ' creo una receta para ' . $request->paciente_nombre,
            'tipo' => 'receta',
            'url' => '/nivel-b',
            'leido' => 0,
            'created_at' => now(),
        ]);

        return redirect('/nivel-a')->with('success', 'Receta creada y enviada para revision');
    }
}
