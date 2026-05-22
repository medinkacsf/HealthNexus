<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Presupuesto - HealthNexus</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;height:100vh;display:flex;flex-direction:column;color:#333}
.header{background:linear-gradient(135deg,#c0392b,#e74c3c);color:white;padding:12px 25px;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:18px}.header-info{display:flex;gap:12px;align-items:center;font-size:13px}
.btn{padding:7px 14px;border-radius:5px;border:none;cursor:pointer;font-size:12px;text-decoration:none;color:white}
.btn-red{background:#c0392b}.btn-green{background:#27ae60}
.back-link{color:rgba(255,255,255,0.8);font-size:12px;text-decoration:none}.back-link:hover{color:white}
.main{display:flex;flex:1;overflow:hidden}
.sidebar{width:250px;background:white;padding:15px;overflow-y:auto;box-shadow:2px 0 10px rgba(0,0,0,0.05)}
.sidebar-title{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:1px;padding:0 12px;margin:12px 0 6px;font-weight:600}
.nav-item{padding:10px 12px;margin-bottom:2px;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:13px;text-decoration:none;color:#333}
.nav-item:hover{background:#f8f9fa}.nav-item.active{background:#fdedec;color:#c0392b;font-weight:bold}
.nav-icon{font-size:16px}
.content{flex:1;padding:20px;overflow-y:auto}
.card{background:white;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:16px}
.card-header{padding:14px 20px;border-bottom:1px solid #eee;background:#f8f9fa}
.card-header h3{font-size:14px;color:#2c3e50}
.card-body{padding:20px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group label{display:block;font-size:11px;font-weight:600;color:#666;margin-bottom:4px;text-transform:uppercase}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none}
.form-group input:focus,.form-group select:focus{border-color:#c0392b}
.form-group.full{grid-column:1/-1}
.servicio-row{display:grid;grid-template-columns:2fr 100px 120px 80px 36px;gap:8px;align-items:center;margin-bottom:8px;padding:8px;background:#f8f9fa;border-radius:6px}
.servicio-row input,.servicio-row select{padding:7px 10px;border:1px solid #ddd;border-radius:5px;font-size:11px;width:100%}
.remove-btn{background:#e74c3c;color:white;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:14px}
.add-btn{background:#27ae60;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;margin-top:8px}
.totals{background:#f8f9fa;padding:16px;border-radius:8px;margin-top:16px}
.totals-row{display:flex;justify-content:space-between;padding:4px 0;font-size:13px}
.totals-row.total{font-size:16px;font-weight:700;color:#c0392b;border-top:2px solid #ddd;padding-top:8px;margin-top:4px}
.actions{display:flex;gap:10px;margin-top:16px}
.alert{padding:12px 18px;border-radius:8px;margin-bottom:16px;font-size:13px}
.alert-success{background:#d4edda;color:#155724}
</style>
</head>
<body>
<div class="header">
<div style="display:flex;align-items:center;gap:12px;">
<a href="/nivel-a" class="back-link">← Volver</a>
<h1> Nuevo Presupuesto</h1>
</div>
<div class="header-info">
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
<a href="/receta/crear" class="nav-item"><span class="nav-icon">📝</span> Receta</a>
<a href="/medicamentos" class="nav-item"><span class="nav-icon">🧪</span> Medicamentos</a>
<div class="sidebar-title">Pacientes</div>
<a href="/nivel-a/pacientes" class="nav-item"><span class="nav-icon">💳</span> Mis Pacientes</a>
<a href="/nivel-a/presupuestos/crear" class="nav-item active"><span class="nav-icon"></span> Nuevo Presupuesto</a>
<a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
</div>
<div class="content">
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }}</div>
@endif
<form method="POST" action="/nivel-a/presupuestos/guardar" id="presupuestoForm">
@csrf
<div class="card">
<div class="card-header"><h3>👤 Datos del Paciente</h3></div>
<div class="card-body">
<div class="form-grid">
<div class="form-group"><label>Nombre del Paciente *</label><input type="text" name="paciente_nombre" required placeholder="Nombre completo"></div>
<div class="form-group"><label>Teléfono</label><input type="text" name="paciente_contacto" placeholder="555-123-4567"></div>
<div class="form-group"><label>Tipo de Paciente</label>
<select name="tipo_paciente"><option value="nuevo">Nuevo</option><option value="existente">Existente</option><option value="asegurado">Asegurado</option></select>
</div>
<div class="form-group"><label>Validez (días)</label><input type="number" name="validez_dias" value="7" min="1" max="30"></div>
<div class="form-group"><label>Estado</label>
<select name="estado"><option value="borrador">Borrador</option><option value="enviado">Enviar al Paciente</option></select>
</div>
<div class="form-group"><label>Descuento (%)</label><input type="number" name="descuento_porcentaje" value="0" min="0" max="100" oninput="calcularTotales()"></div>
<div class="form-group full"><label>Notas</label><textarea name="notas" rows="2" placeholder="Observaciones..."></textarea></div>
</div>
</div>
</div>
<div class="card">
<div class="card-header"><h3> Servicios</h3></div>
<div class="card-body">
<div id="serviciosContainer">
<div class="servicio-row" data-row="0">
<input type="hidden" name="servicios[0][servicio_id]" value="">
<input type="hidden" name="servicios[0][nombre]" value="">
<select onchange="cargarPrecio(this)" style="font-size:11px;">
<option value="">-- Seleccionar --</option>
@foreach($servicios as $s)
<option value="{{ $s->id }}" data-precio="{{ $s->precio_sugerido }}" data-codigo="{{ $s->codigo }}" data-nombre="{{ $s->nombre }}">{{ $s->nombre }} - ${{ number_format($s->precio_sugerido, 2) }}</option>
@endforeach
</select>
<input type="text" name="servicios[0][codigo]" placeholder="Código" readonly>
<input type="number" name="servicios[0][precio]" placeholder="Precio" step="0.01" min="0" oninput="calcularTotales()">
<input type="number" name="servicios[0][cantidad]" value="1" min="1" oninput="calcularTotales()">
<button type="button" class="remove-btn" onclick="removeRow(0)" style="visibility:hidden;">×</button>
</div>
</div>
<button type="button" class="add-btn" onclick="addRow()">➕ Agregar Servicio</button>
<div class="totals">
<div class="totals-row"><span>Subtotal:</span><span id="subtotal">$0.00</span></div>
<div class="totals-row" style="color:#e74c3c;"><span>Descuento:</span><span id="descuento">-$0.00</span></div>
<div class="totals-row total"><span>TOTAL:</span><span id="total">$0.00</span></div>
</div>
<div class="actions">
<button type="submit" class="btn btn-green" style="padding:10px 24px;font-size:13px;">💾 Guardar</button>
<a href="/nivel-a" class="btn btn-red" style="padding:10px 24px;font-size:13px;">Cancelar</a>
</div>
</div>
</div>
</form>
</div>
</div>
<script>
let rowCount = 1;
const serviciosData = @json($servicios);

function cargarPrecio(sel) {
    const row = sel.closest('.servicio-row');
    const opt = sel.options[sel.selectedIndex];
    if (opt.value) {
        row.querySelector('input[name*="[precio]"]').value = opt.dataset.precio;
        row.querySelector('input[name*="[codigo]"]').value = opt.dataset.codigo;
        row.querySelector('input[name*="[nombre]"]').value = opt.dataset.nombre;
        row.querySelector('input[name*="[servicio_id]"]').value = opt.value;
    }
    calcularTotales();
}

function addRow() {
    const c = document.getElementById('serviciosContainer');
    const opts = serviciosData.map(s => '<option value="'+s.id+'" data-precio="'+s.precio_sugerido+'" data-codigo="'+s.codigo+'" data-nombre="'+s.nombre+'">'+s.nombre+' - $'+Number(s.precio_sugerido).toFixed(2)+'</option>').join('');
    c.insertAdjacentHTML('beforeend', '<div class="servicio-row" data-row="'+rowCount+'"><input type="hidden" name="servicios['+rowCount+'][servicio_id]" value=""><input type="hidden" name="servicios['+rowCount+'][nombre]" value=""><select onchange="cargarPrecio(this)" style="font-size:11px;"><option value="">-- Seleccionar --</option>'+opts+'</select><input type="text" name="servicios['+rowCount+'][codigo]" placeholder="Código" readonly><input type="number" name="servicios['+rowCount+'][precio]" placeholder="Precio" step="0.01" min="0" oninput="calcularTotales()"><input type="number" name="servicios['+rowCount+'][cantidad]" value="1" min="1" oninput="calcularTotales()"><button type="button" class="remove-btn" onclick="removeRow('+rowCount+')">×</button></div>');
    rowCount++;
}

function removeRow(idx) {
    const row = document.querySelector('[data-row="'+idx+'"]');
    if (row) row.remove();
    calcularTotales();
}

function calcularTotales() {
    let sub = 0;
    document.querySelectorAll('.servicio-row').forEach(r => {
        const p = parseFloat(r.querySelector('input[name*="[precio]"]')?.value) || 0;
        const q = parseInt(r.querySelector('input[name*="[cantidad]"]')?.value) || 0;
        sub += p * q;
    });
    const dp = parseFloat(document.querySelector('input[name="descuento_porcentaje"]')?.value) || 0;
    const dm = sub * (dp / 100);
    document.getElementById('subtotal').textContent = '$' + sub.toFixed(2);
    document.getElementById('descuento').textContent = '-$' + dm.toFixed(2);
    document.getElementById('total').textContent = '$' + (sub - dm).toFixed(2);
}
</script>
</body>
</html>
