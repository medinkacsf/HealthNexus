<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Presupuesto {{ $presupuesto->codigo }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white;display:inline-block}
.btn-red{background:#c0392b}.btn-green{background:#27ae60}.btn-orange{background:#f39c12}.btn-dark{background:#555}
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
.info-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.info-item label{font-size:10px;color:#999;text-transform:uppercase;display:block;margin-bottom:2px}
.info-item span{font-size:13px;font-weight:500}
.tag{padding:4px 10px;border-radius:12px;font-size:10px;font-weight:700}
.tag-borrador{background:#e2e8f0;color:#4a5568}.tag-enviado{background:#fff3cd;color:#856404}
.tag-aprobado{background:#d4edda;color:#155724}.tag-rechazado{background:#f8d7da;color:#721c24}
table{width:100%;border-collapse:collapse}
th{padding:10px 12px;text-align:left;font-size:10px;color:#999;text-transform:uppercase;background:#f8f9fa;border-bottom:1px solid #eee}
td{padding:10px 12px;font-size:12px;border-bottom:1px solid #f0f0f0}
.totals{background:#f8f9fa;padding:16px 20px;border-radius:8px;margin-top:12px}
.totals-row{display:flex;justify-content:space-between;padding:4px 0;font-size:13px}
.totals-row.total{font-size:18px;font-weight:700;color:#c0392b;border-top:2px solid #ddd;padding-top:8px;margin-top:4px}
.acciones{display:flex;gap:8px;flex-wrap:wrap}
@media print{.sidebar,.header-info form,.acciones,.back-link{display:none!important}.header{background:#333!important}.content{padding:10px!important}}
</style>
</head>
<body>
<div class="header">
<div style="display:flex;align-items:center;gap:12px;">
<a href="/nivel-a" class="back-link">← Volver</a>
<h1> {{ $presupuesto->codigo }}</h1>
</div>
<div class="header-info">
<span class="tag tag-{{ $presupuesto->estado }}">{{ strtoupper($presupuesto->estado) }}</span>
<button onclick="window.print()" class="btn btn-dark"> Imprimir</button>
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
<div class="sidebar-title">Pacientes</div>
<a href="/nivel-a/pacientes" class="nav-item active"><span class="nav-icon"></span> Mis Pacientes</a>
<a href="/nivel-a/presupuestos/crear" class="nav-item"><span class="nav-icon"></span> Nuevo Presupuesto</a>
<a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
</div>
<div class="content">
<div class="card">
<div class="card-header"><h3> Datos</h3></div>
<div class="card-body">
<div class="info-grid">
<div class="info-item"><label>Paciente</label><span>{{ $presupuesto->paciente_nombre }}</span></div>
<div class="info-item"><label>Contacto</label><span>{{ $presupuesto->paciente_contacto ?? '—' }}</span></div>
<div class="info-item"><label>Tipo</label><span>{{ ucfirst($presupuesto->tipo_paciente) }}</span></div>
<div class="info-item"><label>Médico</label><span>{{ $presupuesto->medico_nombre ?? '—' }}</span></div>
<div class="info-item"><label>Validez</label><span>{{ $presupuesto->validez_dias }} días</span></div>
<div class="info-item"><label>Creación</label><span>{{ substr($presupuesto->created_at, 0, 16) }}</span></div>
</div>
@if($presupuesto->notas)
<div style="margin-top:12px;padding:10px;background:#f8f9fa;border-radius:6px;font-size:12px;color:#666;"> {{ $presupuesto->notas }}</div>
@endif
</div>
</div>
<div class="card">
<div class="card-header"><h3> Servicios</h3></div>
<table>
<tr><th>Código</th><th>Servicio</th><th>Cant</th><th style="text-align:right;">P. Unitario</th><th style="text-align:right;">Subtotal</th></tr>
@foreach($detalles as $d)
<tr>
<td>{{ $d->servicio_codigo ?? '—' }}</td>
<td>{{ $d->servicio_nombre }}</td>
<td>{{ $d->cantidad }}</td>
<td style="text-align:right;">${{ number_format($d->precio_unitario, 2) }}</td>
<td style="text-align:right;font-weight:600;">${{ number_format($d->subtotal, 2) }}</td>
</tr>
@endforeach
</table>
<div class="totals">
<div class="totals-row"><span>Subtotal:</span><span>${{ number_format($presupuesto->subtotal, 2) }}</span></div>
@if($presupuesto->descuento_porcentaje > 0)
<div class="totals-row" style="color:#e74c3c;"><span>Descuento ({{ $presupuesto->descuento_porcentaje }}%):</span><span>-${{ number_format($presupuesto->descuento_monto, 2) }}</span></div>
@endif
<div class="totals-row total"><span>TOTAL:</span><span>${{ number_format($presupuesto->total, 2) }}</span></div>
</div>
</div>
<div class="card">
<div class="card-header"><h3> Cambiar Estado</h3></div>
<div class="card-body">
<div class="acciones">
<form method="POST" action="/nivel-a/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf<input type="hidden" name="estado" value="borrador"><button type="submit" class="btn btn-dark"> Borrador</button></form>
<form method="POST" action="/nivel-a/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf<input type="hidden" name="estado" value="enviado"><button type="submit" class="btn btn-orange"> Enviar</button></form>
<form method="POST" action="/nivel-a/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf<input type="hidden" name="estado" value="aprobado"><button type="submit" class="btn btn-green"> Aprobar</button></form>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
