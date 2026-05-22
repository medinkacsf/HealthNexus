<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Pacientes - HealthNexus</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white}
.btn-red{background:#c0392b}.btn-green{background:#27ae60}
.main{display:flex;flex:1;overflow:hidden}
.sidebar{width:250px;background:white;padding:15px;overflow-y:auto;box-shadow:2px 0 10px rgba(0,0,0,0.05)}
.sidebar-title{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:12px 0 6px;font-weight:600}
.nav-item{padding:10px 12px;margin-bottom:2px;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;text-decoration:none;color:#333}
.nav-item:hover{background:#f8f9fa}.nav-item.active{background:#fdedec;color:#c0392b;font-weight:bold}
.nav-icon{font-size:16px}
.content{flex:1;padding:20px;overflow-y:auto}
.summary{display:flex;gap:12px;margin-bottom:20px}
.summary-card{flex:1;background:white;padding:14px 18px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.06)}
.summary-label{font-size:11px;color:#888;margin-bottom:4px}.summary-value{font-size:22px;font-weight:700}
.camilla{display:grid;grid-template-columns:repeat(auto-fill,minmax(155px,1fr));gap:12px}
.cama{background:white;border-radius:10px;padding:16px;text-align:center;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 6px rgba(0,0,0,0.06);border:2px solid transparent}
.cama:hover{transform:translateY(-3px);box-shadow:0 4px 12px rgba(0,0,0,0.12)}
.cama.pagada{border-color:#27ae60;background:#f0fff4}
.cama.ocupada{border-color:#f39c12;background:#fffdf0}
.cama.vencida{border-color:#e74c3c;background:#fff5f5}
.cama-id{font-size:11px;color:#aaa;margin-bottom:4px}
.cama-nombre{font-size:13px;font-weight:600;line-height:1.3;margin-bottom:6px;min-height:34px;display:flex;align-items:center;justify-content:center}
.cama-estado{font-size:9px;font-weight:700;padding:3px 8px;border-radius:10px;display:inline-block;margin-bottom:6px}
.cama-estado.pagada{background:#d4edda;color:#155724}
.cama-estado.pendiente{background:#fff3cd;color:#856404}
.cama-estado.vencida{background:#f8d7da;color:#721c24}
.cama-saldo{font-size:14px;font-weight:700}
.cama-saldo.positivo{color:#e74c3c}.cama-saldo.cero{color:#27ae60}
.empty-state{grid-column:1/-1;padding:40px;text-align:center;color:#aaa;font-size:14px}
.legend{display:flex;gap:16px;margin-bottom:16px;font-size:11px;color:#666}
.legend-item{display:flex;align-items:center;gap:4px}
.legend-dot{width:10px;height:10px;border-radius:50%}
.alert{padding:12px 18px;border-radius:8px;margin-bottom:16px;font-size:13px}
.alert-success{background:#d4edda;color:#155724}
</style>
</head>
<body>
<div class="header">
<h1>💳 Mis Pacientes</h1>
<div class="header-info">
<a href="/expediente/crear" class="btn btn-green">➕ Nuevo Paciente</a><a href="/nivel-a/presupuestos/crear" class="btn btn-blue"> Nuevo Presupuesto</a>
<span>{{ auth()->user()->name }}</span>
<form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red">Salir</button></form>
</div>
</div>
<div class="main">
<div class="sidebar">
<div class="sidebar-title">Consultas</div>
<a href="/nivel-a" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a>
<a href="/citas/agenda" class="nav-item"><span class="nav-icon">📱</span> Agenda</a>
<a href="/expedientes" class="nav-item"><span class="nav-icon">📁</span> Expedientes</a>
<a href="/expediente/crear" class="nav-item"><span class="nav-icon">➕</span> Nuevo Paciente</a>
<a href="/receta/crear" class="nav-item"><span class="nav-icon">📝</span> Receta</a>
<a href="/medicamentos" class="nav-item"><span class="nav-icon">🧪</span> Medicamentos</a>
<div class="sidebar-title">Pacientes</div>
<a href="/expedientes" class="nav-item"><span class="nav-icon">📁</span> Expedientes</a>
<a href="/nivel-a/pacientes" class="nav-item active"><span class="nav-icon">💳</span> Mis Pacientes</a>
<a href="/nivel-a/presupuestos/crear" class="nav-item"><span class="nav-icon"></span> Nuevo Presupuesto</a>
<a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
</div>
<div class="content">
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }}</div>
@endif
<div class="summary">
<div class="summary-card"><div class="summary-label">Total</div><div class="summary-value" style="color:#2980b9;">{{ count($pacientes) }}</div></div>
<div class="summary-card"><div class="summary-label">Pendientes</div><div class="summary-value" style="color:#f39c12;">{{ $pacientes->where('saldo_pendiente', '>', 0)->count() }}</div></div>
<div class="summary-card"><div class="summary-label">Vencidas</div><div class="summary-value" style="color:#e74c3c;">{{ $pacientes->where('estado', 'vencida')->count() }}</div></div>
<div class="summary-card"><div class="summary-label">Pagadas</div><div class="summary-value" style="color:#27ae60;">{{ $pacientes->where('saldo_pendiente', '<=', 0)->count() }}</div></div>
</div>
<div class="legend">
<div class="legend-item"><div class="legend-dot" style="background:#27ae60;"></div> Pagada</div>
<div class="legend-item"><div class="legend-dot" style="background:#f39c12;"></div> Pendiente</div>
<div class="legend-item"><div class="legend-dot" style="background:#e74c3c;"></div> Vencida</div>
</div>
<div class="camilla">
@if(count($pacientes) > 0)
@foreach($pacientes as $p)
<div class="cama {{ $p->saldo_pendiente > 0 ? ($p->estado == 'vencida' ? 'vencida' : 'ocupada') : 'pagada' }}" onclick="location.href='/nivel-a/pacientes/ver/{{ $p->id }}'">
<div class="cama-id">Cuenta #{{ $p->id }}</div>
<div class="cama-nombre">{{ $p->paciente_nombre }}</div>
<div class="cama-estado {{ $p->saldo_pendiente > 0 ? ($p->estado == 'vencida' ? 'vencida' : 'pendiente') : 'pagada' }}">
{{ $p->saldo_pendiente > 0 ? ($p->estado == 'vencida' ? '⚠ VENCIDA' : '⏳ Pendiente') : ' Pagada' }}
</div>
<div class="cama-saldo {{ $p->saldo_pendiente > 0 ? 'positivo' : 'cero' }}">${{ number_format($p->saldo_pendiente, 2) }}</div>
</div>
@endforeach
@else
<div class="empty-state"> Sin pacientes asignados aún.</div>
@endif
</div>
</div>
</div>
</body>
</html>
