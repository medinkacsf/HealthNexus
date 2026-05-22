<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - RRHH</title>
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
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:white;border-radius:var(--radius-lg);padding:20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);text-align:center}
        .stat-card.green{border-top:3px solid var(--green-600)}
        .stat-card.red{border-top:3px solid var(--red-600)}
        .stat-card.blue{border-top:3px solid var(--blue-600)}
        .stat-label{font-size:11px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:8px}
        .stat-value{font-size:26px;font-weight:700}
        .stat-value.green{color:var(--green-600)}.stat-value.red{color:var(--red-600)}.stat-value.blue{color:var(--blue-600)}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:16px 20px}
        table{width:100%;border-collapse:collapse}
        th{padding:8px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:8px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        tr:last-child td{border-bottom:none}
        .bar-container{display:flex;align-items:center;gap:8px;margin-bottom:8px}
        .bar-label{width:120px;font-size:11px;color:var(--neutral-600);text-align:right;flex-shrink:0}
        .bar-track{flex:1;height:20px;background:var(--neutral-100);border-radius:4px;overflow:hidden}
        .bar-fill{height:100%;border-radius:4px;transition:width 0.3s}
        .bar-fill.green{background:var(--green-600)}.bar-fill.red{background:var(--red-600)}.bar-fill.blue{background:var(--blue-600)}.bar-fill.orange{background:var(--orange-600)}.bar-fill.purple{background:var(--purple-600)}
        .bar-value{width:100px;font-size:11px;font-weight:600;color:var(--neutral-800)}
        .mini-stat{display:inline-block;background:var(--neutral-50);padding:6px 12px;border-radius:var(--radius-md);margin-right:8px;margin-bottom:8px;font-size:12px}
        .mini-stat strong{color:var(--blue-600)}
        .empty{padding:20px;text-align:center;color:var(--neutral-400);font-size:13px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Reportes Financieros</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Finanzas</div><a href="/rh/cuentas" class="nav-item"><span class="nav-icon"></span> Cuentas</a><a href="/rh/servicios" class="nav-item"><span class="nav-icon"></span> Servicios</a><a href="/rh/movimientos" class="nav-item"><span class="nav-icon"></span> Movimientos</a><a href="/rh/ajustes" class="nav-item"><span class="nav-icon"></span> Ajustes</a><a href="/rh/reportes" class="nav-item active"><span class="nav-icon"></span> Reportes</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon"></span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon"></span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            <!-- RESUMEN GENERAL -->
            <div class="stats-grid">
                <div class="stat-card green">
                    <div class="stat-label"> Total Ingresos</div>
                    <div class="stat-value green">${{ number_format($totalIngresos, 2) }}</div>
                </div>
                <div class="stat-card red">
                    <div class="stat-label"> Total Egresos</div>
                    <div class="stat-value red">${{ number_format($totalEgresos, 2) }}</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-label"> Balance Neto</div>
                    <div class="stat-value blue">${{ number_format($balance, 2) }}</div>
                </div>
            </div>

            <div class="grid-2">
                <!-- INGRESOS POR CUENTA -->
                <div class="card">
                    <div class="card-header"><h3> Ingresos por Cuenta</h3></div>
                    <div class="card-body">
                        @php $maxIng = $ingresosPorCuenta->max('total') ?? 1; @endphp
                        @if(count($ingresosPorCuenta) > 0)
                        @foreach($ingresosPorCuenta as $i)
                        <div class="bar-container">
                            <div class="bar-label">{{ $i->codigo }}</div>
                            <div class="bar-track"><div class="bar-fill green" style="width:{{ ($i->total/$maxIng)*100 }}%"></div></div>
                            <div class="bar-value">${{ number_format($i->total, 0) }}</div>
                        </div>
                        @endforeach
                        @else
                        <div class="empty">Sin datos</div>
                        @endif
                    </div>
                </div>

                <!-- EGRESOS POR CUENTA -->
                <div class="card">
                    <div class="card-header"><h3> Egresos por Cuenta</h3></div>
                    <div class="card-body">
                        @php $maxEgr = $egresosPorCuenta->max('total') ?? 1; @endphp
                        @if(count($egresosPorCuenta) > 0)
                        @foreach($egresosPorCuenta as $e)
                        <div class="bar-container">
                            <div class="bar-label">{{ $e->codigo }}</div>
                            <div class="bar-track"><div class="bar-fill red" style="width:{{ ($e->total/$maxEgr)*100 }}%"></div></div>
                            <div class="bar-value">${{ number_format($e->total, 0) }}</div>
                        </div>
                        @endforeach
                        @else
                        <div class="empty">Sin datos</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid-2">
                <!-- INGRESOS POR SERVICIO -->
                <div class="card">
                    <div class="card-header"><h3> Ingresos por Servicio</h3></div>
                    <div class="card-body">
                        @php $maxSvc = $ingresosPorServicio->max('total') ?? 1; @endphp
                        @if(count($ingresosPorServicio) > 0)
                        @foreach($ingresosPorServicio as $s)
                        <div class="bar-container">
                            <div class="bar-label">{{ $s->codigo }}</div>
                            <div class="bar-track"><div class="bar-fill blue" style="width:{{ ($s->total/$maxSvc)*100 }}%"></div></div>
                            <div class="bar-value">${{ number_format($s->total, 0) }} <span style="color:var(--neutral-400);font-weight:normal;">({{ $s->cantidad }})</span></div>
                        </div>
                        @endforeach
                        @else
                        <div class="empty">Sin datos</div>
                        @endif
                    </div>
                </div>

                <!-- MOVIMIENTOS POR MES -->
                <div class="card">
                    <div class="card-header"><h3> Movimientos por Mes</h3></div>
                    <div class="card-body">
                        @php $maxMes = max($movimientosMes->max('ingresos') ?? 0, $movimientosMes->max('egresos') ?? 0, 1); @endphp
                        @if(count($movimientosMes) > 0)
                        @foreach($movimientosMes as $m)
                        <div style="margin-bottom:12px;">
                            <div style="font-size:11px;color:var(--neutral-600);margin-bottom:4px;font-weight:600;">{{ $m->mes }}</div>
                            <div class="bar-container" style="margin-bottom:2px;">
                                <div class="bar-label" style="width:50px;">Ing</div>
                                <div class="bar-track"><div class="bar-fill green" style="width:{{ ($m->ingresos/$maxMes)*100 }}%"></div></div>
                                <div class="bar-value">${{ number_format($m->ingresos, 0) }}</div>
                            </div>
                            <div class="bar-container">
                                <div class="bar-label" style="width:50px;">Egr</div>
                                <div class="bar-track"><div class="bar-fill red" style="width:{{ ($m->egresos/$maxMes)*100 }}%"></div></div>
                                <div class="bar-value">${{ number_format($m->egresos, 0) }}</div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="empty">Sin datos</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RESUMEN DE ESTADOS -->
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header"><h3> Resumen de Estados</h3></div>
                <div class="card-body">
                    <div style="margin-bottom:12px;">
                        <strong style="font-size:12px;color:var(--neutral-600);">Cuentas por estado:</strong><br>
                        @foreach($cuentasPorEstado as $c)
                        <span class="mini-stat">{{ ucfirst($c->estado) }}: <strong>{{ $c->total }}</strong></span>
                        @endforeach
                    </div>
                    <div>
                        <strong style="font-size:12px;color:var(--neutral-600);">Servicios por prioridad:</strong><br>
                        @foreach($serviciosPorPrioridad as $s)
                        <span class="mini-stat">{{ ucfirst($s->prioridad) }}: <strong>{{ $s->total }}</strong></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
