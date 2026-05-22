<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Presupuesto - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-600:#38a169;--red-50:#fff5f5;--red-600:#e53e3e;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-green{background:var(--green-600)}.btn-dark{background:var(--neutral-600)}.btn-outline{background:transparent;border:1.5px solid var(--neutral-200);color:var(--neutral-600)}.btn-red{background:var(--red-600)}.btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;margin-bottom:20px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:20px}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px}
        .form-group input:focus,.form-group select:focus{outline:none;border-color:var(--blue-600);box-shadow:0 0 0 3px var(--blue-50)}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--neutral-100)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-danger{background:var(--red-50);color:var(--red-600);border:1px solid var(--red-100)}
        .servicios-list{margin-top:16px}
        .servicio-row{display:grid;grid-template-columns:2fr 80px 120px 120px 40px;gap:8px;align-items:center;margin-bottom:8px}
        .servicio-row input,.servicio-row select{padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px}
        .servicio-row input:focus{outline:none;border-color:var(--blue-600)}
        .remove-btn{background:var(--red-600);color:white;border:none;border-radius:6px;width:32px;height:32px;cursor:pointer;font-size:14px}
        .totals-box{background:var(--neutral-50);padding:16px;border-radius:var(--radius-md);margin-top:16px}
        .totals-box .row{display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px}
        .totals-box .row.total{font-size:16px;font-weight:700;color:var(--blue-600);border-top:2px solid var(--neutral-200);padding-top:8px;margin-top:8px;margin-bottom:0}
    </style>
</head>
<body>
    <div class="header">
        <h1> Nuevo Presupuesto</h1>
        <div class="header-right"><span>{{ auth()->user()->name }}</span><form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form></div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon">💳</span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item active"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>@endif
            <form method="POST" action="/rh/presupuestos/guardar" id="formPresupuesto">
                @csrf
                <div class="card">
                    <div class="card-header"><h3>👤 Datos del Paciente</h3></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre del Paciente *</label>
                                <input type="text" name="paciente_nombre" placeholder="Nombre completo" required>
                            </div>
                            <div class="form-group">
                                <label>Contacto</label>
                                <input type="text" name="paciente_contacto" placeholder="Teléfono o email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Tipo de Paciente *</label>
                                <select name="tipo_paciente" required>
                                    <option value="nuevo">Nuevo</option>
                                    <option value="existente">Existente</option>
                                    <option value="asegurado">Asegurado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Médico</label>
                                <select name="medico_id">
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Dr. Jefe Martinez</option>
                                    <option value="4">Medico Cristian</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Validez (días) *</label>
                                <input type="number" name="validez_dias" value="7" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <select name="estado">
                                    <option value="borrador">Borrador</option>
                                    <option value="enviado">Enviar al Paciente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
                        <h3> Servicios</h3>
                        <button type="button" onclick="agregarServicio()" class="btn btn-green btn-sm">+ Agregar Servicio</button>
                    </div>
                    <div class="card-body">
                        <div class="servicio-row" style="font-size:10px;color:var(--neutral-400);text-transform:uppercase;font-weight:600;margin-bottom:12px;">
                            <div>Servicio</div><div>Cant</div><div>P. Unitario</div><div>Subtotal</div><div></div>
                        </div>
                        <div id="serviciosContainer">
                            <div class="servicio-row">
                                <select name="servicios[0][servicio_id]" onchange="llenarServicio(this, 0)" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                                    <option value="">Seleccionar servicio...</option>
                                    @foreach($servicios as $s)
                                    <option value="{{ $s->id }}" data-nombre="{{ $s->nombre }}" data-codigo="{{ $s->codigo }}" data-precio="{{ $s->precio_sugerido }}">{{ $s->codigo }} - {{ $s->nombre }} (${{ number_format($s->precio_sugerido, 2) }})</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="servicios[0][nombre]" id="nombre_0">
                                <input type="hidden" name="servicios[0][codigo]" id="codigo_0">
                                <input type="number" name="servicios[0][cantidad]" value="1" min="1" onchange="calcSubtotal(0)" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                                <input type="number" name="servicios[0][precio]" value="0" step="0.01" min="0" onchange="calcSubtotal(0)" id="precio_0" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                                <input type="text" value="$0.00" id="subtotal_0" readonly style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;background:var(--neutral-50);font-weight:600;">
                                <button type="button" class="remove-btn" onclick="this.parentElement.remove();recalcular()" title="Quitar">×</button>
                            </div>
                        </div>
                        
                        <div class="totals-box">
                            <div class="row"><span>Subtotal:</span><span id="totalSubtotal">$0.00</span></div>
                            <div class="form-row" style="margin:8px 0;">
                                <div class="form-group" style="margin:0;">
                                    <label style="font-size:11px;">Descuento %</label>
                                    <input type="number" name="descuento_porcentaje" value="0" min="0" max="100" step="0.5" onchange="recalcular()" id="descPct" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                                </div>
                                <div class="form-group" style="margin:0;">
                                    <label style="font-size:11px;">Descuento $</label>
                                    <input type="text" value="$0.00" id="descMonto" readonly style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;background:var(--neutral-50);">
                                </div>
                            </div>
                            <div class="row total"><span>TOTAL:</span><span id="totalFinal">$0.00</span></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3>📝 Notas</h3></div>
                    <div class="card-body">
                        <textarea name="notas" rows="3" placeholder="Notas adicionales para el paciente..." style="width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px;"></textarea>
                        <div class="form-actions">
                            <a href="/rh/presupuestos" class="btn btn-outline">Cancelar</a>
                            <button type="submit" class="btn btn-green">💾 Guardar Presupuesto</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let idx = 1;
        function agregarServicio() {
            const html = `<div class="servicio-row">
                <select name="servicios[${idx}][servicio_id]" onchange="llenarServicio(this, ${idx})" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                    <option value="">Seleccionar...</option>
                    @foreach($servicios as $s)
                    <option value="{{ $s->id }}" data-nombre="{{ $s->nombre }}" data-codigo="{{ $s->codigo }}" data-precio="{{ $s->precio_sugerido }}">{{ $s->codigo }} - {{ $s->nombre }} (${{ number_format($s->precio_sugerido, 2) }})</option>
                    @endforeach
                </select>
                <input type="hidden" name="servicios[${idx}][nombre]" id="nombre_${idx}">
                <input type="hidden" name="servicios[${idx}][codigo]" id="codigo_${idx}">
                <input type="number" name="servicios[${idx}][cantidad]" value="1" min="1" onchange="calcSubtotal(${idx})" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                <input type="number" name="servicios[${idx}][precio]" value="0" step="0.01" min="0" onchange="calcSubtotal(${idx})" id="precio_${idx}" style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;">
                <input type="text" value="$0.00" id="subtotal_${idx}" readonly style="padding:8px 10px;border:1px solid var(--neutral-200);border-radius:6px;font-size:12px;background:var(--neutral-50);font-weight:600;">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove();recalcular()">×</button>
            </div>`;
            document.getElementById('serviciosContainer').insertAdjacentHTML('beforeend', html);
            idx++;
        }
        function llenarServicio(sel, i) {
            const opt = sel.options[sel.selectedIndex];
            if(opt.value) {
                document.getElementById('nombre_'+i).value = opt.dataset.nombre;
                document.getElementById('codigo_'+i).value = opt.dataset.codigo;
                document.getElementById('precio_'+i).value = opt.dataset.precio;
                calcSubtotal(i);
            }
        }
        function calcSubtotal(i) {
            const cant = parseFloat(document.querySelector(`[name="servicios[${i}][cantidad]"]`)?.value || 0);
            const prec = parseFloat(document.getElementById('precio_'+i)?.value || 0);
            const sub = cant * prec;
            document.getElementById('subtotal_'+i).value = '$' + sub.toFixed(2);
            recalcular();
        }
        function recalcular() {
            let total = 0;
            document.querySelectorAll('[id^="subtotal_"]').forEach(el => {
                total += parseFloat(el.value.replace('$','')) || 0;
            });
            const descPct = parseFloat(document.getElementById('descPct').value) || 0;
            const descMonto = total * (descPct / 100);
            document.getElementById('totalSubtotal').textContent = '$' + total.toFixed(2);
            document.getElementById('descMonto').textContent = '-$' + descMonto.toFixed(2);
            document.getElementById('totalFinal').textContent = '$' + (total - descMonto).toFixed(2);
        }
    </script>
</body>
</html>
