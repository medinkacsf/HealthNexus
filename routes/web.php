<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IAController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\NivelAController;
use App\Http\Controllers\FarmaciaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\RHController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\MedicamentosController;

Route::middleware('audit.log')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth', 'audit.log'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/ia/alertas', [IAController::class, 'getAlertas']);
    Route::post('/ia/validar-receta', [IAController::class, 'validarReceta']);
    Route::post('/ia/detectar-fuga', [IAController::class, 'detectarFuga']);

    Route::get('/superadmin', [SuperAdminController::class, 'dashboard'])->name('superadmin');

    // Médico (Nivel A)
    Route::get('/nivel-a', [NivelAController::class, 'dashboard'])->name('nivel.a');
    Route::get('/nivel-a/pacientes', [NivelAController::class, 'misPacientes'])->name('nivel.a.pacientes');
    Route::get('/nivel-a/pacientes/ver/{id}', [NivelAController::class, 'verPaciente'])->name('nivel.a.pacientes.ver');
    Route::get('/nivel-a/presupuestos/crear', [NivelAController::class, 'crearPresupuesto'])->name('nivel.a.presupuestos.crear');
    Route::post('/nivel-a/presupuestos/guardar', [NivelAController::class, 'guardarPresupuesto'])->name('nivel.a.presupuestos.guardar');
    Route::get('/nivel-a/presupuestos/ver/{id}', [NivelAController::class, 'verPresupuesto'])->name('nivel.a.presupuestos.ver');
    Route::post('/nivel-a/presupuestos/estado/{id}', [NivelAController::class, 'cambiarEstadoPresupuesto'])->name('nivel.a.presupuestos.estado');
    Route::get('/nivel-a/servicios', [NivelAController::class, 'verServicios'])->name('nivel.a.servicios');
    Route::get('/nivel-a/supervision', [NivelAController::class, 'supervision'])->name('nivel.a.supervision');
    Route::post('/nivel-a/supervision/enviar', [NivelAController::class, 'enviarReferencia'])->name('nivel.a.supervision.enviar');

    // Expedientes
    Route::get('/expedientes', [ExpedienteController::class, 'listar'])->name('expedientes');
    Route::get('/expediente/crear', [ExpedienteController::class, 'crearExpediente'])->name('expediente.crear');
    Route::post('/expediente/guardar', [ExpedienteController::class, 'guardarExpediente'])->name('expediente.guardar');
    Route::get('/expediente/ver/{id}', [ExpedienteController::class, 'ver'])->name('expediente.ver');
    Route::post('/expediente/nota/{id}', [ExpedienteController::class, 'agregarNota'])->name('expediente.nota');

    // Recetas
    Route::get('/receta/crear', [RecetaController::class, 'crear'])->name('receta.crear');
    Route::post('/receta/guardar', [RecetaController::class, 'guardar'])->name('receta.guardar');
    Route::get('/receta/ver/{receta_id}', [FarmaciaController::class, 'verReceta'])->name('receta.ver');

    // Citas
    Route::get('/citas/agenda', [CitasController::class, 'agenda'])->name('citas.agenda');
    Route::get('/citas/nueva', [CitasController::class, 'nuevaCita'])->name('citas.nueva');
    Route::post('/citas/guardar', [CitasController::class, 'guardarCita'])->name('citas.guardar');
    Route::get('/citas/cambiar/{id}/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiar');
    Route::get('/citas/atender/{id}', [CitasController::class, 'atenderCita'])->name('citas.atender');
    Route::post('/citas/atender/{id}', [CitasController::class, 'guardarAtencion'])->name('citas.atender.guardar');
    Route::get('/citas/imprimir/{id}', [CitasController::class, 'imprimirReceta'])->name('citas.imprimir');

    // Medicamentos
    Route::get('/medicamentos', [MedicamentosController::class, 'index'])->name('medicamentos');

    // Farmacia
    Route::get('/farmacia', [FarmaciaController::class, 'dashboard'])->name('farmacia');
    Route::post('/farmacia/despachar/{receta_id}', [FarmaciaController::class, 'despachar'])->name('farmacia.despachar');

    // RRHH
    Route::get('/rh', [RHController::class, 'dashboard'])->name('rh.dashboard');
    Route::get('/rh/cuentas-pacientes', [RHController::class, 'cuentasPacientes'])->name('rh.cuentas-pacientes');
    Route::get('/rh/cuentas-pacientes/crear', [RHController::class, 'crearCuentaPaciente'])->name('rh.cuentas-pacacientes.crear');
    Route::post('/rh/cuentas-pacientes/guardar', [RHController::class, 'guardarCuentaPaciente'])->name('rh.cuentas-pacientes.guardar');
    Route::get('/rh/cuentas-pacientes/ver/{id}', [RHController::class, 'verCuentaPaciente'])->name('rh.cuentas-pacacientes.ver');
    Route::get('/rh/presupuestos', [RHController::class, 'presupuestos'])->name('rh.presupuestos');
    Route::get('/rh/presupuestos/crear', [RHController::class, 'crearPresupuesto'])->name('rh.presupuestos.crear');
    Route::post('/rh/presupuestos/guardar', [RHController::class, 'guardarPresupuesto'])->name('rh.presupuestos.guardar');
    Route::get('/rh/presupuestos/ver/{id}', [RHController::class, 'verPresupuesto'])->name('rh.presupuestos.ver');
    Route::post('/rh/presupuestos/estado/{id}', [RHController::class, 'cambiarEstadoPresupuesto'])->name('rh.presupuestos.estado');
    Route::get('/rh/pago-servicios', [RHController::class, 'pagoServicios'])->name('rh.pago-servicios');
    Route::post('/rh/pago-servicios/registrar', [RHController::class, 'registrarPago'])->name('rh.pago-servicios.registrar');
    Route::get('/rh/corte-caja', [RHController::class, 'corteCaja'])->name('rh.corte-caja');
    Route::post('/rh/corte-caja/realizar', [RHController::class, 'realizarCorte'])->name('rh.corte-caja.realizar');
    Route::get('/rh/depositos', [RHController::class, 'depositos'])->name('rh.depositos');
    Route::get('/rh/depositos/nuevo', [RHController::class, 'nuevoDeposito'])->name('rh.depositos.nuevo');
    Route::post('/rh/depositos/guardar', [RHController::class, 'guardarDeposito'])->name('rh.depositos.guardar');
    Route::post('/rh/depositos/liberar/{id}', [RHController::class, 'liberarDeposito'])->name('rh.depositos.liberar');
    Route::get('/rh/depositos/aplicar/{id}', [RHController::class, 'aplicarDeposito'])->name('rh.depositos.aplicar');
    Route::get('/rh/solicitudes', [RHController::class, 'solicitudes'])->name('rh.solicitudes');
    Route::get('/rh/aprobar/{id}', [RHController::class, 'autorizar'])->name('rh.aprobar');
    Route::match(['get','post'], '/rh/rechazar/{id}', [RHController::class, 'rechazar'])->name('rh.rechazar');
    Route::get('/rh/anomalias', [RHController::class, 'anomalias'])->name('rh.anomalias');
    Route::post('/rh/detectar-anomalias', [RHController::class, 'detectarAnomalias'])->name('rh.anomalias.detectar');

    // Auditoría
    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.panel');
    Route::match(['get','post'], '/auditoria/detallar/{id}', [AuditoriaController::class, 'detallar'])->name('auditoria.detallar');
});

Route::middleware(['auth', 'admin.role', 'audit.log'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/admin/create-user', [AdminController::class, 'storeUser'])->name('admin.store.user');
});

Route::get('/', function () {
    return redirect('/login');
});


// RUTAS DE FARMACIA
Route::get('/farmacia', [App\Http\Controllers\FarmaciaController::class, 'index'])->name('farmacia.index');
Route::get('/farmacia/surtir/{id}', [App\Http\Controllers\FarmaciaController::class, 'surtir'])->name('farmacia.surtir');
Route::get('/farmacia/imprimir/{id}', [App\Http\Controllers\FarmaciaController::class, 'imprimirTicket'])->name('farmacia.imprimir');
Route::post('/farmacia/confirmar/{id}', [App\Http\Controllers\FarmaciaController::class, 'confirmarDispensacion'])->name('farmacia.confirmar');

// Enviar a Farmacia
Route::get('/citas/enviar-farmacia/{id}', [CitasController::class, 'enviarFarmacia'])->name('citas.enviar_farmacia');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Inventario Farmacia
Route::get('/farmacia/inventario', [App\Http\Controllers\FarmaciaController::class, 'verInventario'])->name('farmacia.inventario');
// Ruta de Cerrar Sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
