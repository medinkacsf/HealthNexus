<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NivelAController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $citas_hoy = DB::table('citas_whatsapp')->whereDate('created_at', today())->count();
        $citas_pendientes = DB::table('citas_whatsapp')->where('estado', 'pendiente')->count();
        $recetas_pendientes = DB::table('recetas')->where('estado', 'pendiente')->count();
        $recetas_firmadas = DB::table('recetas')->where('estado', 'firmada')->count();
        $pendientes = DB::table('notas_medicas')->where('estado', 'pendiente_firma_a')->count();
        $ultimas_citas = DB::table('citas_whatsapp')->orderBy('created_at', 'desc')->limit(8)->get();
        $ultimas_recetas = DB::table('recetas')->orderBy('created_at', 'desc')->limit(5)->get();

        // Pacientes asignados
        $misPacientes = DB::table('cuentas_pacientes')->where('medico_id', $user->id)->whereIn('estado', ['abierta', 'vencida'])->count();

        // Referencias enviadas al Médico C
        $refEnviadas = DB::table('referencias_medicas')->where('medico_origen_id', $user->id)->count();
        $refPendientes = DB::table('referencias_medicas')->where('medico_origen_id', $user->id)->whereIn('estado', ['enviada', 'en_proceso'])->count();

        return view('niveles.nivel_a', compact(
            'user', 'citas_hoy', 'citas_pendientes',
            'recetas_pendientes', 'recetas_firmadas', 'pendientes',
            'ultimas_citas', 'ultimas_recetas',
            'misPacientes', 'refEnviadas', 'refPendientes'
        ));
    }

    // ==========================================
    // MIS PACIENTES (Camilla)
    // ==========================================
    public function misPacientes()
    {
        $pacientes = DB::table('cuentas_pacientes')
            ->where('medico_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
        return view('medico.mis-pacientes', compact('pacientes'));
    }

    public function verPaciente($id)
    {
        $cuenta = DB::table('cuentas_pacientes')->where('id', $id)->where('medico_id', Auth::id())->first();
        if (!$cuenta) { abort(403); }
        $pagos = DB::table('pagos_pacientes')->where('cuenta_paciente_id', $id)->orderBy('created_at', 'desc')->get();
        return view('medico.ver-paciente', compact('cuenta', 'pagos'));
    }

    // ==========================================
    // SUPERVISIÓN - Referencias al Médico C
    // ==========================================
    public function supervision()
    {
        $medicoId = Auth::id();

        // Médicos C disponibles (pasantes)
        $medicosC = DB::table('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->where('role_id', 5)
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        // Referencias que he enviado
        $enviadas = DB::table('referencias_medicas')
            ->where('medico_origen_id', $medicoId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas
        $totalEnviadas = count($enviadas);
        $pendientes = $enviadas->where('estado', 'enviada')->count();
        $enProceso = $enviadas->where('estado', 'en_proceso')->count();
        $atendidas = $enviadas->where('estado', 'atendida')->count();
        $devueltas = $enviadas->where('estado', 'devuelta')->count();

        return view('medico.supervision', compact(
            'medicosC', 'enviadas',
            'totalEnviadas', 'pendientes', 'enProceso', 'atendidas', 'devueltas'
        ));
    }

    public function enviarReferencia(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required|max:150',
            'motivo_referencia' => 'required|max:500',
            'medico_destino_id' => 'required|exists:users,id',
        ]);

        $destino = DB::table('users')->where('id', $request->medico_destino_id)->first();

        DB::table('referencias_medicas')->insert([
            'paciente_nombre' => $request->paciente_nombre,
            'expediente_id' => $request->expediente_id,
            'motivo_referencia' => $request->motivo_referencia,
            'diagnostico_preliminar' => $request->diagnostico_preliminar,
            'medico_origen_id' => Auth::id(),
            'medico_origen_nombre' => Auth::user()->name,
            'medico_destino_id' => $request->medico_destino_id,
            'medico_destino_nombre' => $destino ? $destino->name : 'Desconocido',
            'estado' => 'enviada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/nivel-a/supervision')->with('success', 'Referencia enviada a ' . ($destino ? $destino->name : 'Médico C'));
    }

    // ==========================================
    // PRESUPUESTOS
    // ==========================================
    public function crearPresupuesto()
    {
        $servicios = DB::table('servicios_hospital')->where('estado', 'activo')->orderBy('nombre')->get();
        return view('medico.crear-presupuesto', compact('servicios'));
    }

    public function guardarPresupuesto(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required|max:150',
            'servicios' => 'required|array|min:1',
            'servicios.*.nombre' => 'required',
            'servicios.*.precio' => 'required|numeric|min:0',
            'servicios.*.cantidad' => 'required|integer|min:1',
        ]);

        $codigo = 'PRES-' . str_pad(DB::table('presupuestos')->count() + 1, 3, '0', STR_PAD_LEFT);
        $subtotal = 0;
        foreach ($request->servicios as $s) {
            $subtotal += $s['cantidad'] * $s['precio'];
        }
        $descPct = $request->descuento_porcentaje ?? 0;
        $descMonto = $subtotal * ($descPct / 100);
        $total = $subtotal - $descMonto;

        $presupuestoId = DB::table('presupuestos')->insertGetId([
            'codigo' => $codigo,
            'paciente_nombre' => $request->paciente_nombre,
            'paciente_contacto' => $request->paciente_contacto,
            'medico_id' => Auth::id(),
            'medico_nombre' => Auth::user()->name,
            'tipo_paciente' => $request->tipo_paciente,
            'subtotal' => $subtotal,
            'descuento_porcentaje' => $descPct,
            'descuento_monto' => $descMonto,
            'total' => $total,
            'validez_dias' => $request->validez_dias,
            'estado' => $request->estado ?? 'borrador',
            'notas' => $request->notas,
            'creado_por' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($request->servicios as $s) {
            DB::table('presupuestos_detalles')->insert([
                'presupuesto_id' => $presupuestoId,
                'servicio_id' => $s['servicio_id'] ?? null,
                'servicio_nombre' => $s['nombre'],
                'servicio_codigo' => $s['codigo'] ?? null,
                'cantidad' => $s['cantidad'],
                'precio_unitario' => $s['precio'],
                'subtotal' => $s['cantidad'] * $s['precio'],
                'created_at' => now(),
            ]);
        }

        return redirect('/nivel-a')->with('success', "Presupuesto {$codigo} creado para {$request->paciente_nombre}");
    }

    public function verPresupuesto($id)
    {
        $presupuesto = DB::table('presupuestos')->where('id', $id)->where('medico_id', Auth::id())->first();
        if (!$presupuesto) { abort(403); }
        $detalles = DB::table('presupuestos_detalles')->where('presupuesto_id', $id)->get();
        return view('medico.ver-presupuesto', compact('presupuesto', 'detalles'));
    }

    public function cambiarEstadoPresupuesto(Request $request, $id)
    {
        $request->validate(['estado' => 'required|in:borrador,enviado,aprobado,rechazado,expirado']);
        $presupuesto = DB::table('presupuestos')->where('id', $id)->where('medico_id', Auth::id())->first();
        if (!$presupuesto) { abort(403); }
        DB::table('presupuestos')->where('id', $id)->update(['estado' => $request->estado, 'updated_at' => now()]);
        return back()->with('success', 'Estado actualizado');
    }

    // ==========================================
    // SERVICIOS (Solo lectura)
    // ==========================================
    public function verServicios()
    {
        $servicios = DB::table('servicios_hospital')->where('estado', 'activo')->orderBy('departamento')->orderBy('nombre')->get();
        return view('medico.ver-servicios', compact('servicios'));
    }
}
