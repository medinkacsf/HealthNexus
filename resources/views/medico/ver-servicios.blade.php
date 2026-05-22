<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Catálogo de Servicios - HealthNexus</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white}
.btn-red{background:#c0392b}
.main{display:flex;flex:1;overflow:hidden}
.sidebar{width:250px;background:white;padding:15px;overflow-y:auto;box-shadow:2px 0 10px rgba(0,0,0,0.05)}
.sidebar-title{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:12px 0 6px;font-weight:600}
.nav-item{padding:10px 12px;margin-bottom:2px;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;text-decoration:none;color:#333}
.nav-item:hover{background:#f8f9fa}.nav-item.active{background:#fdedec;color:#c0392b;font-weight:bold}
.nav-icon{font-size:16px}
.content{flex:1;padding:20px;overflow-y:auto}
.card{background:white;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.06);overflow:hidden}
.card-header{padding:14px 20px;border-bottom:1px solid #eee;background:#f8f9fa;display:flex;justify-content:space-between;align-items:center}
.card-header h3{font-size:14px;color:#2c3e50}
table{width:100%;border-collapse:collapse}
th{padding:10px 12px;text-align:left;font-size:10px;color:#999;text-transform:uppercase;background:#f8f9fa;border-bottom:1px solid #eee;position:sticky;top:0}
td{padding:10px 12px;font-size:12px;border-bottom:1px solid #f0f0f0}
tr:hover td{background:#fafafa}
.dept{background:#eaf2f8;color:#2980b9;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:600}
.precio{font-weight:600;color:#27ae60}
.search-bar{margin-bottom:16px}
.search-bar input{padding:9px 14px;border:1px solid #ddd;border-radius:6px;font-size:13px;width:300px;outline:none}
.search-bar input:focus{border-color:#c0392b}
</style>
</head>
<body>
<div class="header">
<h1> Catálogo de Servicios</h1>
<div class="header-info">
<span>{{ count($servicios) }} servicios</span>
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
<a href="/nivel-a/servicios" class="nav-item active"><span class="nav-icon"></span> Ver Servicios</a>
</div>
<div class="content">
<div class="search-bar"><input type="text" id="buscar" placeholder=" Buscar servicio..." oninput="filtrar()"></div>
<div class="card">
<table>
<tr><th>Código</th><th>Servicio</th><th>Departamento</th><th style="text-align:right;">Precio</th></tr>
<tbody id="tbody">
@foreach($servicios as $s)
<tr data-nombre="{{ strtolower($s->nombre) }} {{ strtolower($s->codigo) }} {{ strtolower($s->departamento) }}">
<td><strong>{{ $s->codigo }}</strong></td>
<td>{{ $s->nombre }}</td>
<td><span class="dept">{{ $s->departamento }}</span></td>
<td style="text-align:right;" class="precio">${{ number_format($s->precio_sugerido, 2) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
<script>
function filtrar() {
    const q = document.getElementById('buscar').value.toLowerCase();
    document.querySelectorAll('#tbody tr').forEach(r => {
        r.style.display = r.dataset.nombre.includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
