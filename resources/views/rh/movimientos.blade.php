<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-100:#bee3f8;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--purple-600:#805ad5;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-logout:hover{background:rgba(255,255,255,0.25)}
        .btn-blue{background:var(--blue-600)}.btn-blue:hover{background:var(--primary-light)}
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
        .summary{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px}
        .summary-card{background:white;border-radius:var(--radius-lg);padding:20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);text-align:center}
        .summary-card.green{border-top:3px solid var(--green-600)}
        .summary-card.red{border-top:3px solid var(--red-600)}
        .summary-card.blue{border-top:3px solid var(--blue-600)}
        .summary-label{font-size:11px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:8px}
        .summary-value{font-size:22px;font-weight:700}
        .summary-value.green{color:var(--green-600)}
        .summary-value.red{color:var(--red-600)}
        .summary-value.blue{color:var(--blue-600)}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:0.5px;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 12px;font-size:11px;border-bottom:1px solid var(--neutral-50)}
        tr:hover td{background:var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-ingreso{background:var(--green-100);color:var(--green-600)}
        .tag-egreso{background:var(--red-100);color:var(--red-600)}
        .tag-ajuste{background:var(--purple-100);color:var(--purple-600)}
        .tag-transferencia{background:var(--blue-100);color:var(--blue-600)}
        .tag-completado{background:var(--green-100);color:var(--green-600)}
        .tag-pendiente{background:var(--orange-100);color:var(--orange-600)}
        .tag-anulado{background:var(--neutral-100);color:var(--neutral-600)}
        .monto-ingreso{color:var(--green-600);font-weight:600}
        .monto-egreso{color:var(--red-600);font-weight:600}
        .pagination{padding:12px 20px;display:flex;gap:4px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;border:1px solid var(--neutral-200)}
        .pagination .active{background:var(--blue-600);color:white;border-color:var(--blue-600)}
        .empty{padding:30px;text-align:center;color:var(--neutral-400);font-size:13px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Movimientos Financieros</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Finanzas</div><a href="/rh/cuentas" class="nav-item"><span class="nav-icon"></span> Cuentas</a><a href="/rh/servicios" class="nav-item"><span class="nav-icon"></span> Servicios</a><a href="/rh/movimientos" class="nav-item active"><span class="nav-icon"></span> Movimientos</a><a href="/rh/ajustes" class="nav-item"><span class="nav-icon"></span> Ajustes</a><a href="/rh/reportes" class="nav-item"><span class="nav-icon"></span> Reportes</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon"></span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon"></span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            <div class="summary">
                <div class="summary-card green">
                    <div class="summary-label"> Total Ingresos</div>
                    <div class="summary-value green">${{ number_format($totalIngresos, 2) }}</div>
                </div>
                <div class="summary-card red">
                    <div class="summary-label"> Total Egresos</div>
                    <div class="summary-value red">${{ number_format($totalEgresos, 2) }}</div>
                </div>
                <div class="summary-card blue">
                    <div class="summary-label"> Balance</div>
                    <div class="summary-value blue">${{ number_format($totalIngresos - $totalEgresos, 2) }}</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Historial de Movimientos ({{ $movimientos->total() }})</h3>
                    <a href="/rh/ajustes" class="btn btn-blue btn-sm">+ Registrar Ajuste</a>
                </div>
                <table>
                    <tr><th>Fecha</th><th>Tipo</th><th>Cuenta</th><th>Concepto</th><th>Servicio</th><th>Registró</th><th>Estado</th><th style="text-align:right;">Monto</th></tr>
                    @if(count($movimientos) > 0)
                    @foreach($movimientos as $m)
                    <tr>
                        <td style="white-space:nowrap;color:var(--neutral-400);">{{ substr($m->created_at, 0, 16) }}</td>
                        <td><span class="tag tag-{{ $m->tipo }}">{{ ucfirst($m->tipo) }}</span></td>
                        <td>
                            <div style="font-weight:500;">{{ $m->cuenta_codigo ?? 'N/A' }}</div>
                            <div style="font-size:10px;color:var(--neutral-400);">{{ Str::limit($m->cuenta_nombre, 25) }}</div>
                        </td>
                        <td>{{ Str::limit($m->concepto, 30) }}</td>
                        <td style="font-size:10px;color:var(--neutral-600);">{{ $m->servicio_nombre ?? '—' }}</td>
                        <td style="font-size:10px;color:var(--neutral-400);">{{ $m->registrado_nombre ?? 'Sistema' }}</td>
                        <td><span class="tag tag-{{ $m->estado }}">{{ ucfirst($m->estado) }}</span></td>
                        <td style="text-align:right;" class="monto-{{ $m->tipo }}">
                            {{ $m->tipo == 'ingreso' ? '+' : '-' }}${{ number_format($m->monto, 2) }}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="8" class="empty">Sin movimientos registrados</td></tr>
                    @endif
                </table>
                <div class="pagination">{{ $movimientos->links() }}</div>
            </div>
        </div>
    </div>
</body>
</html>
