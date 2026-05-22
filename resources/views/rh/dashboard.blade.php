<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RRHH - HealthNexus</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--purple-600:#805ad5;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-logout:hover{background:rgba(255,255,255,0.25)}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);cursor:pointer;display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .module-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
        .module-card{background:white;border-radius:var(--radius-lg);padding:24px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);cursor:pointer;transition:all 0.2s;text-decoration:none;color:var(--neutral-800)}
        .module-card:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.1);border-color:var(--blue-600)}
        .module-icon{font-size:28px;margin-bottom:12px}
        .module-title{font-size:15px;font-weight:600;margin-bottom:6px}
        .module-desc{font-size:12px;color:var(--neutral-400);margin-bottom:12px}
        .module-stat{font-size:20px;font-weight:700;color:var(--blue-600)}
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:white;border-radius:var(--radius-lg);padding:16px 20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100)}
        .stat-card.green{border-top:3px solid var(--green-600)}.stat-card.red{border-top:3px solid var(--red-600)}.stat-card.blue{border-top:3px solid var(--blue-600)}.stat-card.orange{border-top:3px solid var(--orange-600)}.stat-card.purple{border-top:3px solid var(--purple-600)}
        .stat-label{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:6px}
        .stat-value{font-size:22px;font-weight:700}
        .stat-value.green{color:var(--green-600)}.stat-value.red{color:var(--red-600)}.stat-value.blue{color:var(--blue-600)}.stat-value.orange{color:var(--orange-600)}.stat-value.purple{color:var(--purple-600)}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:8px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:8px 12px;font-size:11px;border-bottom:1px solid var(--neutral-50)}
        tr:hover td{background:var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-enviado{background:var(--orange-100);color:var(--orange-600)}.tag-aprobado{background:var(--green-100);color:var(--green-600)}.tag-borrador{background:var(--neutral-100);color:var(--neutral-600)}.tag-rechazado{background:var(--red-100);color:var(--red-600)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .btn-sm{padding:6px 12px;font-size:11px;border-radius:6px;border:none;cursor:pointer;font-weight:500;text-decoration:none;color:white;background:var(--blue-600)}
        .empty{padding:20px;text-align:center;color:var(--neutral-400);font-size:12px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Recursos Humanos - HealthNexus</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Cerrar Sesión</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item active"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div>
                <a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon">💳</span> Cuentas Pacientes</a>
                <a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a>
                <a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a>
                <a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a>
                <a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a>
            </div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon">📨</span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon">🚨</span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="stats-grid">
                <div class="stat-card blue"><div class="stat-label">💳 Cuentas Abiertas</div><div class="stat-value blue">{{ $cuentasAbiertas }}</div></div>
                <div class="stat-card red"><div class="stat-label">⚠ Cuentas Vencidas</div><div class="stat-value red">{{ $cuentasVencidas }}</div></div>
                <div class="stat-card green"><div class="stat-label">💰 Cobrado Hoy</div><div class="stat-value green">${{ number_format($pagosHoy, 2) }}</div></div>
                <div class="stat-card orange"><div class="stat-label">🔒 Depósitos Pendientes</div><div class="stat-value orange">{{ $depositosPendientes }}</div></div>
            </div>

            <div class="module-grid">
                <a href="/rh/cuentas-pacientes" class="module-card">
                    <div class="module-icon">💳</div>
                    <div class="module-title">Cuentas de Pacientes</div>
                    <div class="module-desc">Ver cuentas, saldos y pagos</div>
                    <div class="module-stat">${{ number_format($saldoPorCobrar, 2) }} por cobrar</div>
                </a>
                <a href="/rh/presupuestos" class="module-card">
                    <div class="module-icon"></div>
                    <div class="module-title">Presupuestos</div>
                    <div class="module-desc">Cotizaciones para pacientes</div>
                    <div class="module-stat">{{ $presupuestosPendientes }} pendientes</div>
                </a>
                <a href="/rh/pago-servicios" class="module-card">
                    <div class="module-icon">💰</div>
                    <div class="module-title">Pago de Servicios</div>
                    <div class="module-desc">Registrar pagos de pacientes</div>
                    <div class="module-stat">{{ $pagosCount }} pagos hoy</div>
                </a>
                <a href="/rh/corte-caja" class="module-card">
                    <div class="module-icon"> Macy</div>
                    <div class="module-title">Corte de Caja</div>
                    <div class="module-desc">Cierre de turno del día</div>
                    <div class="module-stat">{{ $corteHoy ? ' Cerrado' : '⏳ Pendiente' }}</div>
                </a>
                <a href="/rh/depositos" class="module-card">
                    <div class="module-icon">🔒</div>
                    <div class="module-title">Liberar Depósitos</div>
                    <div class="module-desc">Depósitos de garantía</div>
                    <div class="module-stat">${{ number_format($montoDepositos, 2) }} por liberar</div>
                </a>
                <a href="/rh/anomalias" class="module-card">
                    <div class="module-icon">🚨</div>
                    <div class="module-title">Anomalías IA</div>
                    <div class="module-desc">Detección automática</div>
                    <div class="module-stat">Análisis inteligente</div>
                </a>
            </div>

            <div class="grid-2">
                <div class="card">
                    <div class="card-header"><h3>💰 Últimos Pagos</h3><a href="/rh/pago-servicios" class="btn-sm">Ver todos</a></div>
                    <table>
                        <tr><th>Hora</th><th>Paciente</th><th>Método</th><th>Monto</th></tr>
                        @if(count($ultimosPagos) > 0)
                        @foreach($ultimosPagos as $p)
                        <tr>
                            <td style="color:var(--neutral-400);">{{ substr($p->created_at, 11, 5) }}</td>
                            <td>{{ Str::limit($p->paciente_nombre, 25) }}</td>
                            <td>{{ ucfirst($p->metodo_pago) }}</td>
                            <td style="font-weight:600;color:var(--green-600);">${{ number_format($p->monto, 2) }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="4" class="empty">Sin pagos hoy</td></tr>
                        @endif
                    </table>
                </div>
                <div class="card">
                    <div class="card-header"><h3> Últimos Presupuestos</h3><a href="/rh/presupuestos" class="btn-sm">Ver todos</a></div>
                    <table>
                        <tr><th>Código</th><th>Paciente</th><th>Total</th><th>Estado</th></tr>
                        @if(count($ultimosPresupuestos) > 0)
                        @foreach($ultimosPresupuestos as $pr)
                        <tr>
                            <td><strong>{{ $pr->codigo }}</strong></td>
                            <td>{{ Str::limit($pr->paciente_nombre, 25) }}</td>
                            <td style="font-weight:600;">${{ number_format($pr->total, 2) }}</td>
                            <td><span class="tag tag-{{ $pr->estado }}">{{ ucfirst($pr->estado) }}</span></td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="4" class="empty">Sin presupuestos</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
