<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}.header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-green{background:var(--green-600)}.btn-red{background:var(--red-600)}.btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        tr:hover td{background:var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-pendiente{background:var(--orange-100);color:var(--orange-600)}.tag-aprobada{background:var(--green-100);color:var(--green-600)}.tag-rechazada{background:var(--red-100);color:var(--red-600)}.tag-en_revision{background:var(--blue-100);color:var(--blue-600)}
        .tag-servicio{background:var(--blue-100);color:var(--blue-600)}.tag-medicamento{background:#e9d8fd;color:#805ad5}
        .pagination{padding:12px 20px;display:flex;gap:4px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;border:1px solid var(--neutral-200)}
        .pagination .active{background:var(--blue-600);color:white;border-color:var(--blue-600)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .modal-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:100;justify-content:center;align-items:center}
        .modal-overlay.active{display:flex}
        .modal{background:white;border-radius:var(--radius-lg);width:450px}
        .modal-head{padding:16px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center}
        .modal-head h3{font-size:15px;font-weight:600}
        .modal-body{padding:20px}
        .modal-body label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .modal-body textarea{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px;min-height:80px;resize:vertical}
        .modal-foot{padding:14px 20px;border-top:1px solid var(--neutral-100);display:flex;gap:8px;justify-content:flex-end}
        .btn-dark{background:var(--neutral-600)}
        .empty{padding:30px;text-align:center;color:var(--neutral-400);font-size:13px}
    </style>
</head>
<body>
    <div class="header">
        <h1>📨 Solicitudes de Autorización</h1>
        <div class="header-right"><span>{{ auth()->user()->name }}</span><form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form></div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon">💳</span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item active"><span class="nav-icon">📨</span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon">🚨</span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="card">
                <div class="card-header"><h3> Todas las Solicitudes ({{ $solicitudes->total() }})</h3></div>
                <table>
                    <tr><th>ID</th><th>Fecha</th><th>Solicitante</th><th>Tipo</th><th>Descripción</th><th>Costo</th><th>Estado</th><th>Acciones</th></tr>
                    @if(count($solicitudes) > 0)
                    @foreach($solicitudes as $s)
                    <tr>
                        <td><strong>#{{ $s->id }}</strong></td>
                        <td style="font-size:11px;color:var(--neutral-400);">{{ substr($s->created_at, 0, 10) }}</td>
                        <td>{{ $s->solicitante_nombre }}</td>
                        <td><span class="tag tag-{{ $s->tipo_solicitud }}">{{ ucfirst($s->tipo_solicitud) }}</span></td>
                        <td>{{ Str::limit($s->descripcion, 35) }}</td>
                        <td><strong>${{ number_format($s->costo_solicitado, 2) }}</strong></td>
                        <td><span class="tag tag-{{ $s->estado }}">{{ ucfirst($s->estado) }}</span></td>
                        <td>
                            @if($s->estado == 'pendiente' || $s->estado == 'en_revision')
                                <a href="/rh/aprobar/{{ $s->id }}" class="btn btn-green btn-sm"></a>
                                <button onclick="mostrarModal({{ $s->id }})" class="btn btn-red btn-sm"></button>
                            @else
                                <span style="font-size:11px;color:var(--neutral-400);">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="8" class="empty">Sin solicitudes</td></tr>
                    @endif
                </table>
                <div class="pagination">{{ $solicitudes->links() }}</div>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="modalRechazo">
        <div class="modal">
            <div class="modal-head"><h3> Rechazar Solicitud #<span id="modalId"></span></h3><button onclick="cerrarModal()" style="background:none;border:none;font-size:18px;cursor:pointer;">×</button></div>
            <form method="POST" id="formRechazo">@csrf<input type="hidden" name="solicitud_id" id="solicitudId">
                <div class="modal-body"><label>Motivo del rechazo *</label><textarea name="comentarios" placeholder="Explique por qué se rechaza..." required></textarea></div>
                <div class="modal-foot"><button type="button" onclick="cerrarModal()" class="btn btn-dark">Cancelar</button><button type="submit" class="btn btn-red">Rechazar</button></div>
            </form>
        </div>
    </div>
    <script>
        function mostrarModal(id) { document.getElementById('solicitudId').value = id; document.getElementById('modalId').textContent = id; document.getElementById('formRechazo').action = '/rh/rechazar/' + id; document.getElementById('modalRechazo').classList.add('active'); }
        function cerrarModal() { document.getElementById('modalRechazo').classList.remove('active'); }
    </script>
</body>
</html>
