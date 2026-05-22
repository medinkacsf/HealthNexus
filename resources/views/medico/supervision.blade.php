<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Supervisión - HealthNexus</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white}
.btn-red{background:#c0392b}.btn-green{background:#27ae60}.btn-blue{background:#2980b9}
.back-link{color:rgba(255,255,255,0.8);font-size:12px;text-decoration:none}.back-link:hover{color:white}
.main{display:flex;flex:1;overflow:hidden}
.sidebar{width:250px;background:white;padding:15px;overflow-y:auto;box-shadow:2px 0 10px rgba(0,0,0,0.05)}
.sidebar-title{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:12px 0 6px;font-weight:600}
.nav-item{padding:10px 12px;margin-bottom:2px;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;text-decoration:none;color:#333}
.nav-item:hover{background:#f8f9fa}.nav-item.active{background:#fdedec;color:#c0392b;font-weight:bold}
.nav-icon{font-size:16px}
.content{flex:1;padding:20px;overflow-y:auto}
.summary{display:flex;gap:12px;margin-bottom:20px}
.summary-card{flex:1;background:white;padding:14px 18px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.06);text-align:center}
.summary-label{font-size:11px;color:#888;margin-bottom:4px}
.summary-value{font-size:24px;font-weight:700}
.card{background:white;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:16px}
.card-header{padding:14px 20px;border-bottom:1px solid #eee;background:#f8f9fa;display:flex;justify-content:space-between;align-items:center}
.card-header h3{font-size:14px;color:#2c3e50}
.card-body{padding:20px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group label{display:block;font-size:11px;font-weight:600;color:#666;margin-bottom:4px;text-transform:uppercase}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none}
.form-group input:focus,.form-group select:focus{border-color:#c0392b}
.form-group.full{grid-column:1/-1}
table{width:100%;border-collapse:collapse}
th{padding:10px 12px;text-align:left;font-size:10px;color:#999;text-transform:uppercase;background:#f8f9fa;border-bottom:1px solid #eee}
td{padding:10px 12px;font-size:12px;border-bottom:1px solid #f0f0f0}
tr:hover td{background:#fafafa}
.tag{padding:3px 10px;border-radius:12px;font-size:10px;font-weight:700;display:inline-block}
.tag-enviada{background:#fff3cd;color:#856404}
.tag-en_proceso{background:#cce5ff;color:#004085}
.tag-atendida{background:#d4edda;color:#155724}
.tag-devuelta{background:#f8d7da;color:#721c24}
.tag-aceptada{background:#d1ecf1;color:#0c5460}
.empty-state{padding:30px;text-align:center;color:#aaa;font-size:13px}
.alert{padding:12px 18px;border-radius:8px;margin-bottom:16px;font-size:13px}
.alert-success{background:#d4edda;color:#155724}
.ref-card{border:1px solid #eee;border-radius:8px;padding:14px;margin-bottom:10px;transition:all 0.2s}
.ref-card:hover{box-shadow:0 2px 8px rgba(0,0,0,0.08)}
.ref-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.ref-paciente{font-size:14px;font-weight:600;color:#2c3e50}
.ref-meta{font-size:11px;color:#888;margin-bottom:6px}
.ref-motivo{font-size:12px;color:#555;background:#f8f9fa;padding:8px;border-radius:6px;line-height:1.4}
.ref-destino{font-size:11px;color:#2980b9;font-weight:600}
.ref-notas{font-size:11px;color:#27ae60;background:#f0fff4;padding:8px;border-radius:6px;margin-top:6px}
.actions{display:flex;gap:10px;margin-top:14px}
</style>
</head>
<body>
<div class="header">
<div style="display:flex;align-items:center;gap:12px;">
<a href="/nivel-a" class="back-link">← Volver</a>
<h1> Supervisión - Referencias a Médico C</h1>
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
<a href="/nivel-a/pacientes" class="nav-item"><span class="nav-icon"></span> Mis Pacientes</a>
<a href="/nivel-a/presupuestos/crear" class="nav-item"><span class="nav-icon"></span> Nuevo Presupuesto</a>
<a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
<div class="sidebar-title">Supervisión</div>
<a href="/nivel-a/supervision" class="nav-item active"><span class="nav-icon"></span> Referencias</a>
</div>
<div class="content">
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }}</div>
@endif

<div class="summary">
<div class="summary-card"><div class="summary-label">Total Enviadas</div><div class="summary-value" style="color:#2980b9;">{{ $totalEnviadas }}</div></div>
<div class="summary-card"><div class="summary-label">⏳ Pendientes</div><div class="summary-value" style="color:#f39c12;">{{ $pendientes }}</div></div>
<div class="summary-card"><div class="summary-label"> En Proceso</div><div class="summary-value" style="color:#2980b9;">{{ $enProceso }}</div></div>
<div class="summary-card"><div class="summary-label"> Atendidas</div><div class="summary-value" style="color:#27ae60;">{{ $atendidas }}</div></div>
<div class="summary-card"><div class="summary-label">↩ Devueltas</div><div class="summary-value" style="color:#e74c3c;">{{ $devueltas }}</div></div>
</div>

<!-- ENVIAR NUEVA REFERENCIA -->
<div class="card">
<div class="card-header"><h3> Enviar Nueva Referencia</h3></div>
<div class="card-body">
<form method="POST" action="/nivel-a/supervision/enviar">
@csrf
<div class="form-grid">
<div class="form-group"><label>Paciente *</label><input type="text" name="paciente_nombre" required placeholder="Nombre del paciente"></div>
<div class="form-group"><label>Expediente</label><input type="number" name="expediente_id" placeholder="ID expediente (opcional)"></div>
<div class="form-group"><label>Enviar a (Médico C) *</label>
<select name="medico_destino_id" required>
<option value="">-- Seleccionar pasante --</option>
@foreach($medicosC as $mc)
<option value="{{ $mc->id }}">{{ $mc->name }}</option>
@endforeach
</select>
</div>
<div class="form-group"><label>Diagnóstico Preliminar</label><input type="text" name="diagnostico_preliminar" placeholder="Ej: Cefalea tensional"></div>
<div class="form-group full"><label>Motivo de Referencia *</label><textarea name="motivo_referencia" required rows="3" placeholder="Describa por qué envía este paciente al pasante..."></textarea></div>
</div>
<div class="actions">
<button type="submit" class="btn btn-green" style="padding:10px 24px;font-size:13px;"> Enviar Referencia</button>
</div>
</form>
</div>
</div>

<!-- REFERENCIAS ENVIADAS -->
<div class="card">
<div class="card-header"><h3> Referencias Enviadas ({{ count($enviadas) }})</h3></div>
@if(count($enviadas) > 0)
<div style="padding:12px;">
@foreach($enviadas as $r)
<div class="ref-card" style="border-left:4px solid {{ $r->estado == 'atendida' ? '#27ae60' : ($r->estado == 'devuelta' ? '#e74c3c' : ($r->estado == 'en_proceso' ? '#2980b9' : '#f39c12')) }};">
<div class="ref-header">
<div class="ref-paciente">‍ {{ $r->paciente_nombre }}</div>
<span class="tag tag-{{ $r->estado }}">{{ strtoupper(str_replace('_', ' ', $r->estado)) }}</span>
</div>
<div class="ref-meta">
 Enviado a: <span class="ref-destino">{{ $r->medico_destino_nombre }}</span> ·  {{ substr($r->created_at, 0, 16) }}
@if($r->diagnostico_preliminar) ·  {{ $r->diagnostico_preliminar }} @endif
</div>
<div class="ref-motivo">{{ $r->motivo_referencia }}</div>
@if($r->notas_destino)
<div class="ref-notas"> <strong>Nota del pasante:</strong> {{ $r->notas_destino }}</div>
@endif
</div>
@endforeach
</div>
@else
<div class="empty-state">No has enviado referencias aún</div>
@endif
</div>
</div>
</div>
</body>
</html>
