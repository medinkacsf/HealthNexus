<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $cuenta->paciente_nombre }} - HealthNexus</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white}
.btn-red{background:#c0392b}
.back-link{color:rgba(255,255,255,0.8);font-size:12px;text-decoration:none}.back-link:hover{color:white}
.main{display:flex;flex:1;overflow:hidden}
.sidebar{width:250px;background:white;padding:15px;overflow-y:auto;box-shadow:2px 0 10px rgba(0,0,0,0.05)}
.sidebar-title{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:12px 0 6px;font-weight:600}
.nav-item{padding:10px 12px;margin-bottom:2px;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;text-decoration:none;color:#333}
.nav-item:hover{background:#f8f9fa}.nav-item.active{background:#fdedec;color:#c0392b;font-weight:bold}
.nav-icon{font-size:16px}
.content{flex:1;padding:20px;overflow-y:auto}
.card{background:white;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:16px}
.card-header{padding:14px 20px;border-bottom:1px solid #eee;background:#f8f9fa;display:flex;justify-content:space-between;align-items:center}
.card-header h3{font-size:14px;color:#2c3e50}
.card-body{padding:20px;font-size:13px}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.info-item label{font-size:10px;color:#999;text-transform:uppercase;display:block;margin-bottom:2px}
.info-item span{font-size:13px;font-weight:500}
.progress-bar{height:10px;background:#eee;border-radius:5px;overflow:hidden;margin-top:8px}
.progress-fill{height:100%;background:#27ae60;border-radius:5px}
table{width:100%;border-collapse:collapse}
th{padding:10px 12px;text-align:left;font-size:10px;color:#999;text-transform:uppercase;background:#f8f9fa;border-bottom:1px solid #eee}
td{padding:10px 12px;font-size:12px;border-bottom:1px solid #f0f0f0}
tr:hover td{background:#fafafa}
.tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600}
.tag-abierta{background:#fff3cd;color:#856404}.tag-pagada{background:#d4edda;color:#155724}.tag-vencida{background:#f8d7da;color:#721c24}
.empty-state{padding:30px;text-align:center;color:#aaa;font-size:13px}
.monto-verde{color:#27ae60;font-weight:600}
.fin-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;text-align:center}
.fin-card div:first-child{font-size:11px;color:#999;margin-bottom:4px}
.fin-card div:last-child{font-size:20px;font-weight:700}
</style>
</head>
<body>
<div class="header">
<div style="display:flex;align-items:center;gap:12px;">
<a href="/nivel-a/pacientes" class="back-link">← Volver</a>
<h1> {{ $cuenta->paciente_nombre }}</h1>
</div>
<div class="header-info">
<span>{{ auth()->user()->name }}</span>
<form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red">Salir</button></form>
</div>
</div>
<div class="main">
<div class="sidebar">
<div class="sidebar-title">Consultas</div>
<a href="/nivel-a" class="nav-item"><span class="nav-icon"></span> Dashboard</a>
<a href="/citas/agenda" class="nav-item"><span class="nav-icon"></span> Agenda</a>
<a href="/expedientes" class="nav-item"><span class="nav-icon"></span> Expedientes</a>
<a href="/receta/crear" class="nav-item"><span class="nav-icon"></span> Receta</a>
<a href="/medicamentos" class="nav-item"><span class="nav-icon"></span> Medicamentos</a>
<div class="sidebar-title">Pacientes</div>
<a href="/nivel-a/pacientes" class="nav-item active"><span class="nav-icon"></span> Mis Pacientes</a>
<a href="/nivel-a/presupuestos/crear" class="nav-item"><span class="nav-icon"></span> Nuevo Presupuesto</a>
<a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
</div>
<div class="content">
<div class="card">
<div class="card-header"><h3> Información</h3><span class="tag tag-{{ $cuenta->estado }}">{{ strtoupper($cuenta->estado) }}</span></div>
<div class="card-body">
<div class="info-grid">
<div class="info-item"><label>Paciente</label><span>{{ $cuenta->paciente_nombre }}</span></div>
<div class="info-item"><label>Expediente</label><span>{{ $cuenta->expediente_id ?? 'Sin expediente' }}</span></div>
<div class="info-item"><label>Apertura</label><span>{{ $cuenta->fecha_apertura }}</span></div>
<div class="info-item"><label>Último Pago</label><span>{{ $cuenta->fecha_ultimo_pago ?? 'Sin pagos' }}</span></div>
</div>
<div style="margin-top:16px;">
<div style="display:flex;justify-content:space-between;font-size:12px;color:#666;margin-bottom:4px;">
<span>Progreso de pago</span>
<span>{{ $cuenta->total_cargo > 0 ? round(($cuenta->total_abono / $cuenta->total_cargo) * 100) : 0 }}%</span>
</div>
<div class="progress-bar"><div class="progress-fill" style="width:{{ $cuenta->total_cargo > 0 ? min(100, ($cuenta->total_abono / $cuenta->total_cargo) * 100) : 0 }}%;"></div></div>
</div>
</div>
</div>
<div class="card">
<div class="card-header"><h3> Resumen Financiero</h3></div>
<div class="card-body">
<div class="fin-grid">
<div class="fin-card"><div>Cargo Total</div><div style="color:#2980b9;">${{ number_format($cuenta->total_cargo, 2) }}</div></div>
<div class="fin-card"><div>Abonado</div><div style="color:#27ae60;">${{ number_format($cuenta->total_abono, 2) }}</div></div>
<div class="fin-card"><div>Saldo</div><div style="color:{{ $cuenta->saldo_pendiente > 0 ? '#e74c3c' : '#27ae60' }};">${{ number_format($cuenta->saldo_pendiente, 2) }}</div></div>
</div>
</div>
</div>
<div class="card">
<div class="card-header"><h3> Pagos ({{ count($pagos) }})</h3></div>
@if(count($pagos) > 0)
<table>
<tr><th>Fecha</th><th>Folio</th><th>Método</th><th>Concepto</th><th style="text-align:right;">Monto</th></tr>
@foreach($pagos as $p)
<tr>
<td>{{ substr($p->created_at, 0, 16) }}</td>
<td><strong>{{ $p->recibo_folio }}</strong></td>
<td>{{ ucfirst($p->metodo_pago) }}</td>
<td>{{ $p->concepto }}</td>
<td style="text-align:right;" class="monto-verde">${{ number_format($p->monto, 2) }}</td>
</tr>
@endforeach
</table>
@else
<div class="empty-state">Sin pagos registrados</div>
@endif
</div>
</div>
</div>
</body>
</html>
