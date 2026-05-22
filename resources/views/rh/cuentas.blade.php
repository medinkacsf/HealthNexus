<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-100:#bee3f8;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--purple-600:#805ad5;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-logout:hover{background:rgba(255,255,255,0.25)}
        .btn-green{background:var(--green-600)}.btn-green:hover{background:#2f855a}
        .btn-blue{background:var(--blue-600)}.btn-blue:hover{background:var(--primary-light)}
        .btn-red{background:var(--red-600)}.btn-red:hover{background:#c53030}
        .btn-orange{background:var(--orange-600)}.btn-orange:hover{background:#c05621}
        .btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);cursor:pointer;display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;margin-bottom:20px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 14px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:0.5px;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 14px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        tr:hover td{background:var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-activa{background:var(--green-100);color:var(--green-600)}
        .tag-cerrada{background:var(--neutral-100);color:var(--neutral-600)}
        .tag-congelada{background:var(--orange-100);color:var(--orange-600)}
        .tag-ingreso{background:var(--green-100);color:var(--green-600)}
        .tag-egreso{background:var(--red-100);color:var(--red-600)}
        .tag-servicio{background:var(--blue-100);color:var(--blue-600)}
        .priority-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:4px}
        .priority-critica{background:var(--red-600)}.priority-alta{background:var(--orange-600)}.priority-media{background:var(--blue-600)}.priority-baja{background:var(--neutral-400)}
        .acciones{display:flex;gap:4px}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .pagination{padding:12px 20px;display:flex;gap:4px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;border:1px solid var(--neutral-200)}
        .pagination .active{background:var(--blue-600);color:white;border-color:var(--blue-600)}
        .modal-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:100;justify-content:center;align-items:center}
        .modal-overlay.active{display:flex}
        .modal{background:white;border-radius:var(--radius-lg);width:450px;max-height:90vh;overflow-y:auto}
        .modal-head{padding:16px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center}
        .modal-head h3{font-size:15px;font-weight:600}
        .modal-body{padding:20px}
        .modal-body label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .modal-body textarea,.modal-body select,.modal-body input{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px;margin-bottom:14px}
        .modal-body textarea{min-height:80px;resize:vertical}
        .modal-foot{padding:14px 20px;border-top:1px solid var(--neutral-100);display:flex;gap:8px;justify-content:flex-end}
        .btn-dark{background:var(--neutral-600)}
    </style>
</head>
<body>
    <div class="header">
        <h1> Cuentas Financieras</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Finanzas</div><a href="/rh/cuentas" class="nav-item active"><span class="nav-icon"></span> Cuentas</a><a href="/rh/servicios" class="nav-item"><span class="nav-icon"></span> Servicios</a><a href="/rh/movimientos" class="nav-item"><span class="nav-icon"></span> Movimientos</a><a href="/rh/ajustes" class="nav-item"><span class="nav-icon"></span> Ajustes</a><a href="/rh/reportes" class="nav-item"><span class="nav-icon"></span> Reportes</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon"></span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon"></span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="card">
                <div class="card-header">
                    <h3> Todas las Cuentas ({{ $cuentas->total() }})</h3>
                    <a href="/rh/cuentas/crear" class="btn btn-green btn-sm">+ Nueva Cuenta</a>
                </div>
                <table>
                    <tr><th>Código</th><th>Nombre</th><th>Tipo</th><th>Departamento</th><th>Saldo Actual</th><th>Prioridad</th><th>Estado</th><th>Acciones</th></tr>
                    @foreach($cuentas as $c)
                    <tr>
                        <td><strong>{{ $c->codigo }}</strong></td>
                        <td>{{ $c->nombre }}</td>
                        <td><span class="tag tag-{{ $c->tipo }}">{{ ucfirst($c->tipo) }}</span></td>
                        <td>{{ $c->departamento }}</td>
                        <td style="font-weight:600;">${{ number_format($c->saldo_actual, 2) }}</td>
                        <td><span class="priority-dot priority-{{ $c->prioridad }}"></span>{{ ucfirst($c->prioridad) }}</td>
                        <td><span class="tag tag-{{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
                        <td>
                            <div class="acciones">
                                @if($c->estado == 'activa')
                                    <button onclick="mostrarCerrar({{ $c->id }},'{{ $c->codigo }}')" class="btn btn-red btn-sm" title="Cerrar"></button>
                                    <a href="/rh/cuentas/congelar/{{ $c->id }}" class="btn btn-orange btn-sm" title="Congelar"></a>
                                    <button onclick="mostrarPrioridad({{ $c->id }},'{{ $c->prioridad }}')" class="btn btn-blue btn-sm" title="Cambiar Prioridad">⬆</button>
                                @elseif($c->estado == 'congelada')
                                    <a href="/rh/cuentas/congelar/{{ $c->id }}" class="btn btn-green btn-sm" title="Reactivar">▶</a>
                                    <button onclick="mostrarCerrar({{ $c->id }},'{{ $c->codigo }}')" class="btn btn-red btn-sm" title="Cerrar"></button>
                                @else
                                    <span style="font-size:11px;color:var(--neutral-400);">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="pagination">{{ $cuentas->links() }}</div>
            </div>
        </div>
    </div>

    <!-- MODAL CERRAR -->
    <div class="modal-overlay" id="modalCerrar">
        <div class="modal">
            <div class="modal-head"><h3> Cerrar Cuenta <span id="cerrarCodigo"></span></h3><button onclick="cerrarModal('modalCerrar')" style="background:none;border:none;font-size:18px;cursor:pointer;">×</button></div>
            <form method="POST" action="" id="formCerrar">
                @csrf
                <input type="hidden" id="cerrarId" name="solicitud_id">
                <div class="modal-body">
                    <label>Motivo del cierre *</label>
                    <textarea name="motivo_cierre" placeholder="Explique por qué se cierra esta cuenta..." required></textarea>
                </div>
                <div class="modal-foot">
                    <button type="button" onclick="cerrarModal('modalCerrar')" class="btn btn-dark">Cancelar</button>
                    <button type="submit" class="btn btn-red">Cerrar Cuenta</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PRIORIDAD -->
    <div class="modal-overlay" id="modalPrioridad">
        <div class="modal">
            <div class="modal-head"><h3>⬆ Cambiar Prioridad</h3><button onclick="cerrarModal('modalPrioridad')" style="background:none;border:none;font-size:18px;cursor:pointer;">×</button></div>
            <form method="POST" action="" id="formPrioridad">
                @csrf
                <input type="hidden" id="prioridadId" name="solicitud_id">
                <div class="modal-body">
                    <label>Nueva Prioridad</label>
                    <select name="prioridad" required>
                        <option value="baja">Baja</option>
                        <option value="media">Media</option>
                        <option value="alta">Alta</option>
                        <option value="critica">Crítica</option>
                    </select>
                </div>
                <div class="modal-foot">
                    <button type="button" onclick="cerrarModal('modalPrioridad')" class="btn btn-dark">Cancelar</button>
                    <button type="submit" class="btn btn-blue">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarCerrar(id, codigo) {
            document.getElementById('cerrarId').value = id;
            document.getElementById('cerrarCodigo').textContent = codigo;
            document.getElementById('formCerrar').action = '/rh/cuentas/cerrar/' + id;
            document.getElementById('modalCerrar').classList.add('active');
        }
        function mostrarPrioridad(id, actual) {
            document.getElementById('prioridadId').value = id;
            document.getElementById('formPrioridad').action = '/rh/cuentas/prioridad/' + id;
            document.querySelector('#formPrioridad select[name="prioridad"]').value = actual;
            document.getElementById('modalPrioridad').classList.add('active');
        }
        function cerrarModal(id) { document.getElementById(id).classList.remove('active'); }
    </script>
</body>
</html>
