<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-100:#bee3f8;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-logout:hover{background:rgba(255,255,255,0.25)}
        .btn-green{background:var(--green-600)}.btn-green:hover{background:#2f855a}
        .btn-blue{background:var(--blue-600)}.btn-blue:hover{background:var(--primary-light)}
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
        .tag-activo{background:var(--green-100);color:var(--green-600)}
        .tag-inactivo{background:var(--red-100);color:var(--red-600)}
        .tag-en_revision{background:var(--orange-100);color:var(--orange-600)}
        .priority-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:4px}
        .priority-critica{background:var(--red-600)}.priority-alta{background:var(--orange-600)}.priority-media{background:var(--blue-600)}.priority-baja{background:var(--neutral-400)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .pagination{padding:12px 20px;display:flex;gap:4px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;border:1px solid var(--neutral-200)}
        .pagination .active{background:var(--blue-600);color:white;border-color:var(--blue-600)}
        .precio{font-weight:600}
        .precio-costo{color:var(--red-600)}
        .precio-venta{color:var(--green-600)}
        .margen{font-size:10px;color:var(--neutral-400)}
    </style>
</head>
<body>
    <div class="header">
        <h1> Servicios del Hospital</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Finanzas</div><a href="/rh/cuentas" class="nav-item"><span class="nav-icon"></span> Cuentas</a><a href="/rh/servicios" class="nav-item active"><span class="nav-icon"></span> Servicios</a><a href="/rh/movimientos" class="nav-item"><span class="nav-icon"></span> Movimientos</a><a href="/rh/ajustes" class="nav-item"><span class="nav-icon"></span> Ajustes</a><a href="/rh/reportes" class="nav-item"><span class="nav-icon"></span> Reportes</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon"></span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon"></span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="card">
                <div class="card-header">
                    <h3> Catálogo de Servicios ({{ $servicios->total() }})</h3>
                    <a href="/rh/servicios/crear" class="btn btn-green btn-sm">+ Nuevo Servicio</a>
                </div>
                <table>
                    <tr><th>Código</th><th>Nombre</th><th>Departamento</th><th>Costo Op.</th><th>Precio Sugerido</th><th>Margen</th><th>Prioridad</th><th>Estado</th><th>Acciones</th></tr>
                    @foreach($servicios as $s)
                    <?php
                        $margen = $s->costo_operativo > 0 ? (($s->precio_sugerido - $s->costo_operativo) / $s->costo_operativo * 100) : 0;
                        $margenColor = $margen >= 100 ? 'var(--green-600)' : ($margen >= 50 ? 'var(--orange-600)' : 'var(--red-600)');
                    ?>
                    <tr>
                        <td><strong>{{ $s->codigo }}</strong></td>
                        <td>{{ $s->nombre }}</td>
                        <td style="font-size:11px;color:var(--neutral-600);">{{ $s->departamento }}</td>
                        <td class="precio precio-costo">${{ number_format($s->costo_operativo, 2) }}</td>
                        <td class="precio precio-venta">${{ number_format($s->precio_sugerido, 2) }}</td>
                        <td><span class="margen" style="color:{{ $margenColor }};">{{ number_format($margen, 0) }}%</span></td>
                        <td><span class="priority-dot priority-{{ $s->prioridad }}"></span>{{ ucfirst($s->prioridad) }}</td>
                        <td><span class="tag tag-{{ $s->estado }}">{{ $s->estado == 'en_revision' ? 'En Revisión' : ucfirst($s->estado) }}</span></td>
                        <td>
                            <a href="/rh/servicios/editar/{{ $s->id }}" class="btn btn-blue btn-sm"> Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="pagination">{{ $servicios->links() }}</div>
            </div>
        </div>
    </div>
</body>
</html>
