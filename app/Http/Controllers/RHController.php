<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RHController extends Controller
{
    public function dashboard()
    {
        $cuentasAbiertas = DB::table('cuentas_pacientes')->where('estado', 'abierta')->count();
        $cuentasVencidas = DB::table('cuentas_pacientes')->where('estado', 'vencida')->count();
        $saldoPorCobrar = DB::table('cuentas_pacientes')->where('estado', 'abierta')->sum('saldo_pendiente');
        $presupuestosPendientes = DB::table('presupuestos')->where('estado', 'enviado')->count();
        $presupuestosHoy = DB::table('presupuestos')->whereDate('created_at', today())->count();
        $pagosHoy = DB::table('pagos_pacientes')->whereDate('created_at', today())->where('estado', 'completado')->sum('monto');
        $pagosCount = DB::table('pagos_pacientes')->whereDate('created_at', today())->where('estado', 'completado')->count();
        $depositosPendientes = DB::table('depositos_pacientes')->where('estado', 'depositado')->count();
        $montoDepositos = DB::table('depositos_pacientes')->where('estado', 'depositado')->sum('monto');
        $corteHoy = DB::table('cortes_caja')->where('fecha', today())->where('turno', 'matutino')->first();
        $ultimosPagos = DB::table('pagos_pacientes')->join('cuentas_pacientes', 'pagos_pacientes.cuenta_paciente_id', '=', 'cuentas_pacientes.id')->select('pagos_pacientes.*', 'cuentas_pacientes.paciente_nombre')->orderBy('pagos_pacientes.created_at', 'desc')->limit(8)->get();
        $ultimosPresupuestos = DB::table('presupuestos')->orderBy('created_at', 'desc')->limit(5)->get();
        return view('rh.dashboard', compact('cuentasAbiertas', 'cuentasVencidas', 'saldoPorCobrar', 'presupuestosPendientes', 'presupuestosHoy', 'pagosHoy', 'pagosCount', 'depositosPendientes', 'montoDepositos', 'corteHoy', 'ultimosPagos', 'ultimosPresupuestos'));
    }

    public function cuentasPacientes()
    {
        $cuentas = DB::table('cuentas_pacientes')->orderBy('estado', 'asc')->orderBy('id', 'desc')->paginate(15);
        $totalPorCobrar = DB::table('cuentas_pacientes')->where('estado', 'abierta')->sum('saldo_pendiente');
        $totalVencido = DB::table('cuentas_pacientes')->where('estado', 'vencida')->sum('saldo_pendiente');
        return view('rh.cuentas-pacientes', compact('cuentas', 'totalPorCobrar', 'totalVencido'));
    }

    public function verCuentaPaciente($id)
    {
        $cuenta = DB::table('cuentas_pacientes')->where('id', $id)->first();
        $pagos = DB::table('pagos_pacientes')->where('cuenta_paciente_id', $id)->orderBy('created_at', 'desc')->get();
        return view('rh.ver-cuenta-paciente', compact('cuenta', 'pagos'));
    }

    public function crearCuentaPaciente()
    {
        return view('rh.crear-cuenta-paciente');
    }

    public function guardarCuentaPaciente(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required|max:150',
            'total_cargo' => 'nullable|numeric|min:0',
            'fecha_apertura' => 'required|date',
        ]);
        $cargo = $request->total_cargo ?? 0;
        $medicoNombre = null;
        if ($request->medico_id) {
            $medico = DB::table('users')->where('id', $request->medico_id)->first();
            $medicoNombre = $medico ? $medico->name : null;
        }
        DB::table('cuentas_pacientes')->insert([
            'paciente_nombre' => $request->paciente_nombre,
            'medico_id' => $request->medico_id,
            'medico_nombre' => $medicoNombre,
            'expediente_id' => $request->expediente_id,
            'total_cargo' => $cargo,
            'total_abono' => 0,
            'saldo_pendiente' => $cargo,
            'estado' => 'abierta',
            'fecha_apertura' => $request->fecha_apertura,
            'creado_por' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/rh/cuentas-pacientes')->with('success', 'Cuenta de paciente creada');
    }

    public function presupuestos()
    {
        $presupuestos = DB::table('presupuestos')->orderBy('id', 'desc')->paginate(15);
        $enviados = DB::table('presupuestos')->where('estado', 'enviado')->count();
        $aprobados = DB::table('presupuestos')->where('estado', 'aprobado')->count();
        $totalEnviados = DB::table('presupuestos')->where('estado', 'enviado')->sum('total');
        return view('rh.presupuestos', compact('presupuestos', 'enviados', 'aprobados', 'totalEnviados'));
    }

    public function crearPresupuesto()
    {
        $servicios = DB::table('servicios_hospital')->where('estado', 'activo')->get();
        return view('rh.crear-presupuesto', compact('servicios'));
    }

    public function guardarPresupuesto(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required|max:150',
            'paciente_contacto' => 'nullable|max:100',
            'tipo_paciente' => 'required|in:nuevo,existente,asegurado',
            'validez_dias' => 'required|integer|min:1',
            'servicios' => 'required|array',
            'servicios.*.nombre' => 'required',
            'servicios.*.cantidad' => 'required|integer|min:1',
            'servicios.*.precio' => 'required|numeric|min:0',
        ]);
        $codigo = 'PRES-' . str_pad(DB::table('presupuestos')->count() + 1, 3, '0', STR_PAD_LEFT);
        $medicoNombre = null;
        if ($request->medico_id) {
            $medico = DB::table('users')->where('id', $request->medico_id)->first();
            $medicoNombre = $medico ? $medico->name : null;
        }
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
            'medico_id' => $request->medico_id,
            'medico_nombre' => $medicoNombre,
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
        return redirect('/rh/presupuestos')->with('success', "Presupuesto {$codigo} creado");
    }

    public function verPresupuesto($id)
    {
        $presupuesto = DB::table('presupuestos')->where('id', $id)->first();
        $detalles = DB::table('presupuestos_detalles')->where('presupuesto_id', $id)->get();
        return view('rh.ver-presupuesto', compact('presupuesto', 'detalles'));
    }

    public function cambiarEstadoPresupuesto(Request $request, $id)
    {
        $request->validate(['estado' => 'required|in:borrador,enviado,aprobado,rechazado,expirado']);
        DB::table('presupuestos')->where('id', $id)->update(['estado' => $request->estado, 'updated_at' => now()]);
        return redirect('/rh/presupuestos')->with('success', 'Estado actualizado');
    }

    public function pagoServicios()
    {
        $cuentas = DB::table('cuentas_pacientes')->whereIn('estado', ['abierta', 'vencida'])->orderBy('id', 'desc')->get();
        $pagos = DB::table('pagos_pacientes')->join('cuentas_pacientes', 'pagos_pacientes.cuenta_paciente_id', '=', 'cuentas_pacientes.id')->select('pagos_pacientes.*', 'cuentas_pacientes.paciente_nombre')->orderBy('pagos_pacientes.created_at', 'desc')->paginate(15);
        $totalHoy = DB::table('pagos_pacientes')->whereDate('created_at', today())->where('estado', 'completado')->sum('monto');
        return view('rh.pago-servicios', compact('cuentas', 'pagos', 'totalHoy'));
    }

    public function registrarPago(Request $request)
    {
        $request->validate([
            'cuenta_paciente_id' => 'required|exists:cuentas_pacientes,id',
            'monto' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,cheque,seguro,deposito',
            'referencia' => 'nullable|max:100',
            'concepto' => 'required|max:200',
        ]);
        DB::beginTransaction();
        try {
            $folio = 'REC-' . str_pad(DB::table('pagos_pacientes')->count() + 1, 4, '0', STR_PAD_LEFT);
            DB::table('pagos_pacientes')->insert([
                'cuenta_paciente_id' => $request->cuenta_paciente_id,
                'monto' => $request->monto,
                'metodo_pago' => $request->metodo_pago,
                'referencia' => $request->referencia,
                'concepto' => $request->concepto,
                'recibio' => Auth::id(),
                'recibo_folio' => $folio,
                'estado' => 'completado',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $cuenta = DB::table('cuentas_pacientes')->where('id', $request->cuenta_paciente_id)->first();
            $nuevoAbono = $cuenta->total_abono + $request->monto;
            $nuevoSaldo = $cuenta->saldo_pendiente - $request->monto;
            $nuevoEstado = $nuevoSaldo <= 0 ? 'pagada' : $cuenta->estado;
            DB::table('cuentas_pacientes')->where('id', $request->cuenta_paciente_id)->update([
                'total_abono' => $nuevoAbono,
                'saldo_pendiente' => max(0, $nuevoSaldo),
                'estado' => $nuevoEstado,
                'fecha_ultimo_pago' => today(),
                'updated_at' => now(),
            ]);
            DB::table('audit_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'pago_registrado',
                'module' => 'rrhh',
                'descripcion' => "Pago {$folio}: \${$request->monto} de {$cuenta->paciente_nombre}",
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);
            DB::commit();
            return redirect('/rh/pago-servicios')->with('success', "Pago {$folio} registrado");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function corteCaja()
    {
        $hoy = today()->toDateString();
        $corteMatutino = DB::table('cortes_caja')->where('fecha', $hoy)->where('turno', 'matutino')->first();
        $corteVespertino = DB::table('cortes_caja')->where('fecha', $hoy)->where('turno', 'vespertino')->first();
        $pagosHoy = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->select('metodo_pago', DB::raw('SUM(monto) as total'), DB::raw('COUNT(*) as cantidad'))->groupBy('metodo_pago')->get()->keyBy('metodo_pago');
        $totalHoy = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->sum('monto');
        $cortesAnteriores = DB::table('cortes_caja')->orderBy('fecha', 'desc')->limit(10)->get();
        return view('rh.corte-caja', compact('corteMatutino', 'corteVespertino', 'pagosHoy', 'totalHoy', 'cortesAnteriores'));
    }

    public function realizarCorte(Request $request)
    {
        $request->validate(['turno' => 'required|in:matutino,vespertino,nocturno', 'saldo_inicial' => 'required|numeric|min:0', 'observaciones' => 'nullable|max:500']);
        $hoy = today()->toDateString();
        $existe = DB::table('cortes_caja')->where('fecha', $hoy)->where('turno', $request->turno)->first();
        if ($existe) { return back()->with('error', 'Ya existe un corte para este turno'); }
        $efectivo = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->where('metodo_pago', 'efectivo')->sum('monto');
        $tarjeta = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->where('metodo_pago', 'tarjeta')->sum('monto');
        $transferencia = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->where('metodo_pago', 'transferencia')->sum('monto');
        $seguro = DB::table('pagos_pacientes')->whereDate('created_at', $hoy)->where('estado', 'completado')->where('metodo_pago', 'seguro')->sum('monto');
        $totalGeneral = $efectivo + $tarjeta + $transferencia + $seguro;
        DB::table('cortes_caja')->insert([
            'fecha' => $hoy, 'turno' => $request->turno, 'cajero_id' => Auth::id(), 'cajero_nombre' => Auth::user()->name,
            'saldo_inicial' => $request->saldo_inicial, 'total_ingresos_efectivo' => $efectivo, 'total_ingresos_tarjeta' => $tarjeta,
            'total_ingresos_transferencia' => $transferencia, 'total_ingresos_seguro' => $seguro, 'total_general' => $totalGeneral,
            'total_egresos' => 0, 'saldo_final' => $request->saldo_inicial + $efectivo, 'diferencia' => 0,
            'observaciones' => $request->observaciones, 'estado' => 'cerrado', 'cerrado_por' => Auth::id(),
            'fecha_cierre' => now(), 'created_at' => now(), 'updated_at' => now(),
        ]);
        return redirect('/rh/corte-caja')->with('success', 'Corte de caja realizado');
    }

    public function depositos()
    {
        $depositos = DB::table('depositos_pacientes')->orderBy('id', 'desc')->paginate(15);
        $pendientes = DB::table('depositos_pacientes')->where('estado', 'depositado')->count();
        $montoPendiente = DB::table('depositos_pacientes')->where('estado', 'depositado')->sum('monto');
        return view('rh.depositos', compact('depositos', 'pendientes', 'montoPendiente'));
    }

    public function nuevoDeposito()
    {
        $cuentas = DB::table('cuentas_pacientes')->whereIn('estado', ['abierta', 'vencida'])->get();
        return view('rh.nuevo-deposito', compact('cuentas'));
    }

    public function guardarDeposito(Request $request)
    {
        $request->validate([
            'paciente_nombre' => 'required|max:150', 'cuenta_paciente_id' => 'nullable|exists:cuentas_pacientes,id',
            'monto' => 'required|numeric|min:0.01', 'concepto' => 'required|max:200',
            'metodo_pago' => 'required|max:50', 'referencia' => 'nullable|max:100', 'fecha_deposito' => 'required|date',
        ]);
        DB::table('depositos_pacientes')->insert([
            'paciente_nombre' => $request->paciente_nombre, 'cuenta_paciente_id' => $request->cuenta_paciente_id,
            'monto' => $request->monto, 'concepto' => $request->concepto, 'metodo_pago' => $request->metodo_pago,
            'referencia' => $request->referencia, 'estado' => 'depositado', 'fecha_deposito' => $request->fecha_deposito,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        return redirect('/rh/depositos')->with('success', 'Depósito registrado');
    }

    public function liberarDeposito(Request $request, $id)
    {
        $request->validate(['motivo_liberacion' => 'required|max:500']);
        DB::table('depositos_pacientes')->where('id', $id)->update([
            'estado' => 'liberado', 'fecha_liberacion' => today(), 'liberado_por' => Auth::id(),
            'motivo_liberacion' => $request->motivo_liberacion, 'updated_at' => now(),
        ]);
        return redirect('/rh/depositos')->with('success', 'Depósito liberado');
    }

    public function aplicarDeposito($id)
    {
        $deposito = DB::table('depositos_pacientes')->where('id', $id)->first();
        if (!$deposito || $deposito->estado != 'depositado') { return back()->with('error', 'Depósito no disponible'); }
        DB::beginTransaction();
        try {
            DB::table('depositos_pacientes')->where('id', $id)->update([
                'estado' => 'aplicado', 'fecha_liberacion' => today(), 'liberado_por' => Auth::id(),
                'motivo_liberacion' => 'Aplicado a cuenta del paciente', 'updated_at' => now(),
            ]);
            if ($deposito->cuenta_paciente_id) {
                $cuenta = DB::table('cuentas_pacientes')->where('id', $deposito->cuenta_paciente_id)->first();
                if ($cuenta) {
                    $nuevoAbono = $cuenta->total_abono + $deposito->monto;
                    $nuevoSaldo = $cuenta->saldo_pendiente - $deposito->monto;
                    DB::table('cuentas_pacientes')->where('id', $deposito->cuenta_paciente_id)->update([
                        'total_abono' => $nuevoAbono, 'saldo_pendiente' => max(0, $nuevoSaldo),
                        'estado' => $nuevoSaldo <= 0 ? 'pagada' : $cuenta->estado,
                        'fecha_ultimo_pago' => today(), 'updated_at' => now(),
                    ]);
                }
            }
            DB::commit();
            return redirect('/rh/depositos')->with('success', 'Depósito aplicado a cuenta del paciente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function solicitudes()
    {
        $solicitudes = DB::table('autorizaciones_costo')->orderBy('id', 'desc')->paginate(15);
        return view('rh.solicitudes', compact('solicitudes'));
    }

    public function autorizar($id)
    {
        DB::table('autorizaciones_costo')->where('id', $id)->update(['estado' => 'aprobada', 'updated_at' => now()]);
        DB::table('rh_movimientos')->insert(['autorizacion_id' => $id, 'tipo_movimiento' => 'aprobacion', 'usuario_id' => Auth::id(), 'usuario_nombre' => Auth::user()->name, 'detalle' => 'Solicitud aprobada', 'created_at' => now()]);
        return redirect('/rh/solicitudes')->with('success', 'Solicitud aprobada');
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate(['comentarios' => 'required|max:500']);
        DB::table('autorizaciones_costo')->where('id', $id)->update(['estado' => 'rechazada', 'comentarios' => $request->comentarios, 'updated_at' => now()]);
        DB::table('rh_movimientos')->insert(['autorizacion_id' => $id, 'tipo_movimiento' => 'rechazo', 'usuario_id' => Auth::id(), 'usuario_nombre' => Auth::user()->name, 'detalle' => $request->comentarios, 'created_at' => now()]);
        return redirect('/rh/solicitudes')->with('success', 'Solicitud rechazada');
    }

    public function anomalias()
    {
        $anomalias = DB::table('autorizaciones_costo')->where('anomalia_detectada', true)->orderBy('id', 'desc')->get();
        return view('rh.anomalias', compact('anomalias'));
    }

    public function detectarAnomalias()
    {
        $solicitudes = DB::table('autorizaciones_costo')->where('estado', 'pendiente')->get();
        $detectadas = 0;
        foreach ($solicitudes as $s) {
            $anomalia = false; $tipo = null; $detalle = null;
            if ($s->tipo_solicitud == 'servicio' && $s->costo_solicitado > 5000) { $anomalia = true; $tipo = 'costo_excesivo'; $detalle = "Servicio excede rango"; }
            if ($s->tipo_solicitud == 'medicamento' && $s->costo_solicitado > 2000) { $anomalia = true; $tipo = 'precio_fuera_rango'; $detalle = "Medicamento fuera de rango"; }
            if (stripos($s->descripcion, 'morfina') !== false || stripos($s->descripcion, 'ketamina') !== false) { $anomalia = true; $tipo = 'estupefaciente'; $detalle = "Sustancia controlada"; }
            $duplicados = DB::table('autorizaciones_costo')->where('descripcion', $s->descripcion)->where('id', '!=', $s->id)->whereDate('created_at', today())->count();
            if ($duplicados > 0) { $anomalia = true; $tipo = 'posible_duplicado'; $detalle = "{$duplicados} solicitudes similares"; }
            if ($anomalia) {
                DB::table('autorizaciones_costo')->where('id', $s->id)->update(['anomalia_detectada' => true, 'anomalia_tipo' => $tipo, 'anomalia_detalle' => $detalle, 'estado' => 'en_revision', 'updated_at' => now()]);
                $detectadas++;
            }
        }
        return redirect('/rh/anomalias')->with('success', "Análisis completado. {$detectadas} anomalías.");
    }
}
