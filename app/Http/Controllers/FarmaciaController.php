<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FarmaciaController extends Controller
{
    public function index()
    {
        // 1. Recetas Pendientes
        $pendientes = DB::table('atenciones')
            ->join('citas_whatsapp', 'atenciones.cita_id', '=', 'citas_whatsapp.id')
            ->join('users', 'atenciones.medico_id', '=', 'users.id')
            ->select('atenciones.*', 'citas_whatsapp.telefono', 'users.name as medico_nombre')
            ->where('atenciones.estado_farmacia', 'pendiente')
            ->orderBy('atenciones.created_at', 'desc')
            ->get();

        // 2. Surtidas Hoy
        $surtidasHoy = DB::table('atenciones')
            ->where('estado_farmacia', 'dispensada')
            ->whereDate('updated_at', now()) // Usamos now() para mayor compatibilidad
            ->count();

        // 3. Surtidas Recientes (Historial)
        $surtidas = DB::table('atenciones')
            ->join('citas_whatsapp', 'atenciones.cita_id', '=', 'citas_whatsapp.id')
            ->select('atenciones.*', 'citas_whatsapp.telefono')
            ->where('atenciones.estado_farmacia', 'dispensada')
            ->orderBy('atenciones.updated_at', 'desc')
            ->limit(5)
            ->get();

        // 4. Alertas de Stock (PredictAI)
        $alertasStock = DB::table('cuadro_basico')
            ->where('existencia', '<', 5)
            ->orderBy('existencia', 'asc')
            ->get();

        // IMPORTANTE: Pasamos todas las variables aqui
        return view('niveles.farmacia_dashboard', compact(
            'pendientes', 
            'surtidas', 
            'surtidasHoy', 
            'alertasStock'
        ));
    }

    public function reponerStock(Request $request, $id)
    {
        $cantidad = $request->input('cantidad', 10); 
        DB::table('cuadro_basico')->where('id', $id)->increment('existencia', $cantidad);
        return back()->with('success', "Stock repuesto (+{$cantidad} unidades).");
    }

    public function surtir($id)
    {
        $atencion = DB::table('atenciones')->where('id', $id)->first();
        if (!$atencion) return back()->with('error', 'Receta no encontrada');
        return redirect()->route('farmacia.imprimir', $id);
    }

    public function confirmarDispensacion($id)
    {
        $atencion = DB::table('atenciones')->where('id', $id)->first();
        if (!$atencion) return back()->with('error', 'Error');

        $recetaTexto = strtolower($atencion->receta_medica);
        $medicamentosInventario = DB::table('cuadro_basico')->get();

        foreach ($medicamentosInventario as $med) {
            if (strpos($recetaTexto, strtolower($med->nombre_medicamento)) !== false) {
                if ($med->existencia > 0) {
                    DB::table('cuadro_basico')->where('id', $med->id)->decrement('existencia');
                }
            }
        }

        DB::table('atenciones')->where('id', $id)->update([
            'estado_farmacia' => 'dispensada',
            'updated_at' => now()
        ]);

        return redirect('/farmacia')->with('success', 'Receta dispensada y stock actualizado.');
    }

    public function imprimirTicket($id)
    {
        $data = DB::table('atenciones')
            ->join('citas_whatsapp', 'atenciones.cita_id', '=', 'citas_whatsapp.id')
            ->join('users', 'atenciones.medico_id', '=', 'users.id')
            ->select('atenciones.*', 'users.name as medico_nombre', 'citas_whatsapp.telefono')
            ->where('atenciones.id', $id)
            ->first();

        return view('niveles.farmacia_ticket', compact('data'));
    }

    public function verInventario()
    {
        $medicamentos = DB::table('cuadro_basico')->orderBy('nombre_medicamento')->get();
        return view('niveles.farmacia_inventario', compact('medicamentos'));
    }
}
