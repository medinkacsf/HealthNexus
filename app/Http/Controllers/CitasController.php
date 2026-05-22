<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CitasController extends Controller
{
    public function agenda()
    {
        $user = Auth::user();
        $citas = DB::table('citas_whatsapp')->orderBy('created_at', 'desc')->get();
        $pendientes = DB::table('citas_whatsapp')->where('estado', 'pendiente')->count();
        $confirmadas = DB::table('citas_whatsapp')->where('estado', 'confirmada')->count();
        $atendidas = DB::table('citas_whatsapp')->where('estado', 'atendida')->count();
        $hoy = DB::table('citas_whatsapp')->whereDate('created_at', today())->count();

        $horarios = [
            '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
            '11:00', '11:30', '12:00', '13:00', '13:30', '14:00',
            '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'
        ];

        $citas_hoy = DB::table('citas_whatsapp')
            ->whereDate('created_at', today())
            ->where('estado', 'confirmada')
            ->pluck('horario')
            ->toArray();

        return view('niveles.citas_agenda', compact(
            'user', 'citas', 'pendientes', 'confirmadas', 'atendidas', 'hoy',
            'horarios', 'citas_hoy'
        ));
    }

    public function cambiarEstado($id, $estado)
    {
        DB::table('citas_whatsapp')->where('id', $id)->update([
            'estado' => $estado,
            'updated_at' => now()
        ]);
        return back()->with('success', 'Cita actualizada');
    }

    public function atenderCita($id)
    {
        $cita = DB::table('citas_whatsapp')->where('id', $id)->first();
        if (!$cita) { abort(404); }
        return view('niveles.atender-cita', compact('cita'));
    }

    public function guardarAtencion(Request $request, $id)
    {
        $request->validate([
            'diagnostico' => 'required|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $atencionId = DB::table('atenciones')->insertGetId([
                'cita_id' => $id,
                'medico_id' => Auth::id(),
                'paciente_nombre' => $request->paciente_nombre,
                'presion_arterial' => $request->presion_arterial,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
                'temperatura' => $request->temperatura,
                'peso' => $request->peso,
                'talla' => $request->talla,
                'spo2' => $request->spo2,
                'motivo_consulta' => $request->motivo_consulta,
                'exploracion_fisica' => $request->exploracion_fisica,
                'diagnostico' => $request->diagnostico,
                'cie10' => $request->cie10,
                'receta_medica' => $request->receta_medica,
                'indicaciones' => $request->indicaciones,
                'notas_medicas' => $request->notas_medicas,
                'estado_farmacia' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $updated = DB::table('citas_whatsapp')->where('id', $id)->update([
                'estado' => 'atendida',
                'updated_at' => now()
            ]);

            if (!$updated) {
                throw new \Exception("No se pudo actualizar el estado de la cita.");
            }

            DB::commit();

            return redirect('/citas/agenda')->with('success', 'Consulta guardada y enviada a Farmacia ');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error guardando atención: " . $e->getMessage());
            return back()->withInput()->with('error', 'Hubo un error al guardar: ' . $e->getMessage());
        }
    }

    // Función para enviar manualmente a farmacia desde la agenda
    public function enviarFarmacia($id)
    {
        DB::table('atenciones')->where('cita_id', $id)->update(['estado_farmacia' => 'pendiente']);
        return redirect('/citas/agenda')->with('success', 'Receta enviada a Farmacia correctamente ');
    }

    public function imprimirReceta($id)
    {
        $data = DB::table('atenciones')
            ->join('citas_whatsapp', 'atenciones.cita_id', '=', 'citas_whatsapp.id')
            ->join('users', 'atenciones.medico_id', '=', 'users.id')
            ->select('atenciones.*', 'users.name as medico_nombre', 'citas_whatsapp.telefono')
            ->where('atenciones.cita_id', $id)
            ->first();

        if (!$data) {
            return back()->with('error', 'No se encontró la atención médica.');
        }
        return view('niveles.imprimir_receta', compact('data'));
    }

    public function nuevaCita()
    {
        $user = Auth::user();
        return view('niveles.crear_cita', compact('user'));
    }

    public function guardarCita(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required',
            'telefono' => 'required',
            'motivo' => 'required',
            'fecha' => 'required',
            'horario' => 'required',
        ]);

        DB::table('citas_whatsapp')->insert([
            'paciente_nombre' => $request->paciente_nombre,
            'telefono' => $request->telefono,
            'motivo' => $request->motivo,
            'fecha_cita' => $request->fecha,
            'horario' => $request->horario,
            'estado' => 'confirmada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/citas/agenda')->with('success', 'Cita creada');
    }
}
