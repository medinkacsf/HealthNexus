<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>RRHH - HealthNexus</title>
    <style>
        :root {
            --red-50: #FFF0F0; --red-100: #FFCDD0; --red-200: #F59B9F;
            --red-400: #E03B42; --red-600: #B01E25; --red-800: #7A0E14;
            --blue-50: #EBF4FF; --blue-100: #BDDCFF; --blue-200: #85BCFF;
            --blue-400: #2F7EF5; --blue-600: #1456C8; --blue-800: #0A348C;
            --neutral-50: #F7F8FA; --neutral-200: #D8DAE2; --neutral-400: #9096A8;
            --neutral-600: #565C70; --neutral-800: #2A2E3D;
            --color-primary: var(--red-400); --color-secondary: var(--blue-400);
            --color-surface: #ffffff; --color-bg: var(--neutral-50);
            --font-sans: 'Segoe UI', system-ui, sans-serif;
            --radius-sm: 4px; --radius-md: 8px; --radius-lg: 14px; --radius-pill: 999px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-sans); background: var(--color-bg); height: 100vh; display: flex; flex-direction: column; color: var(--neutral-800); }
        .header { background: linear-gradient(135deg, var(--red-600), var(--red-400)); color: white; padding: 14px 28px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 12px rgba(0,0,0,0.15); }
        .header h1 { font-size: 18px; font-weight: 600; }
        .header-info { display: flex; gap: 12px; align-items: center; }
        .badge { background: rgba(255,255,255,0.2); padding: 5px 14px; border-radius: var(--radius-pill); font-size: 12px; }
        .btn { padding: 8px 16px; border-radius: var(--radius-md); border: none; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; color: white; transition: all 0.2s; }
        .btn:hover { opacity: 0.9; }
        .btn-dark { background: var(--neutral-800); }
        .btn-red { background: var(--red-600); }
        .btn-blue { background: var(--blue-600); }
        .btn-outline { background: transparent; border: 2px solid white; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .sidebar { width: 260px; background: var(--color-surface); padding: 20px; overflow-y: auto; border-right: 1px solid var(--neutral-200); }
        .sidebar h3 { color: var(--neutral-600); margin-bottom: 16px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .nav-item { padding: 11px 14px; margin-bottom: 3px; border-radius: var(--radius-md); cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 13px; text-decoration: none; color: var(--neutral-600); transition: all 0.2s; border-left: 3px solid transparent; }
        .nav-item:hover { background: var(--blue-50); color: var(--blue-600); border-left-color: var(--blue-400); }
        .nav-item.active { background: var(--red-50); color: var(--red-600); border-left-color: var(--red-400); font-weight: 600; }
        .content { flex: 1; padding: 24px; overflow-y: auto; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat { background: var(--color-surface); padding: 20px; border-radius: var(--radius-lg); box-shadow: 0 1px 4px rgba(0,0,0,0.04); text-align: center; border: 1px solid var(--neutral-200); }
        .stat-num { font-size: 32px; font-weight: 700; }
        .stat-label { color: var(--neutral-400); font-size: 12px; margin-top: 4px; }
        .stat-red .stat-num { color: var(--red-400); }
        .stat-blue .stat-num { color: var(--blue-400); }
        .stat-green .stat-num { color: #27ae60; }
        .stat-orange .stat-num { color: #e67e22; }
        .card { background: var(--color-surface); border-radius: var(--radius-lg); box-shadow: 0 1px 4px rgba(0,0,0,0.04); margin-bottom: 20px; border: 1px solid var(--neutral-200); overflow: hidden; }
        .card-head { padding: 14px 20px; border-bottom: 1px solid var(--neutral-200); display: flex; justify-content: space-between; align-items: center; background: var(--neutral-50); }
        .card-head h3 { font-size: 14px; font-weight: 600; }
        .card-body { padding: 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 11px; color: var(--neutral-400); text-transform: uppercase; border-bottom: 2px solid var(--neutral-200); background: var(--neutral-50); }
        .table td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--neutral-200); }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover { background: var(--blue-50); }
        .tag { padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; }
        .tag-pendiente { background: var(--blue-100); color: var(--blue-600); }
        .tag-aprobada { background: #d4edda; color: #155724; }
        .tag-rechazada { background: var(--red-100); color: var(--red-600); }
        .tag-revision { background: #fff3cd; color: #856404; }
        .empty { padding: 40px; text-align: center; color: var(--neutral-400); font-size: 13px; }
        .mini-table { width: 100%; }
        .mini-table td { padding: 6px 12px; font-size: 12px; border-bottom: 1px solid var(--neutral-200); }
        .mini-table tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
    <div class="header">
        <h1>👥 Recursos Humanos - HealthNexus</h1>
        <div class="header-info">
            <span class="badge">{{ $user->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-outline">Salir</button></form>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <h3>Menú RRHH</h3>
            <a href="/rh" class="nav-item active"><span>📊</span> Dashboard</a>
            <a href="/rh/solicitudes" class="nav-item"><span></span> Solicitudes ({{ $pendientes }})</a>
            <a href="/rh/anomalias" class="nav-item"><span>🚨</span> Anomalías ({{ $anomalias }})</a>
            <a href="/auditoria" class="nav-item"><span>🔒</span> Auditoría</a>

            <div style="margin-top:24px;padding:14px;background:var(--blue-50);border-radius:var(--radius-md);border:1px solid var(--blue-100);">
                <div style="font-size:11px;color:var(--blue-600);font-weight:600;margin-bottom:8px;">💰 COSTO PENDIENTE</div>
                <div style="font-size:20px;font-weight:700;color:var(--blue-400);">${{ number_format($costo_pendiente, 2) }}</div>
            </div>

            <div style="margin-top:12px;padding:14px;background:var(--green-50);border-radius:var(--radius-md);border:1px solid #d4edda;">
                <div style="font-size:11px;color:#155724;font-weight:600;margin-bottom:8px;"> COSTO AUTORIZADO HOY</div>
                <div style="font-size:20px;font-weight:700;color:#27ae60;">${{ number_format($total_costo, 2) }}</div>
            </div>

            <div style="margin-top:12px;padding:14px;background:var(--red-50);border-radius:var(--radius-md);border:1px solid var(--red-100);">
                <div style="font-size:11px;color:var(--red-600);font-weight:600;margin-bottom:8px;">⚠ ANOMALÍAS</div>
                <div style="font-size:20px;font-weight:700;color:var(--red-400);">{{ $anomalias }}</div>
            </div>
        </div>

        <div class="content">
            <div class="stats">
                <div class="stat stat-blue">
                    <div class="stat-num">{{ $pendientes }}</div>
                    <div class="stat-label">⏳ Pendientes</div>
                </div>
                <div class="stat stat-green">
                    <div class="stat-num">{{ $aprobadas }}</div>
                    <div class="stat-label"> Aprobadas</div>
                </div>
                <div class="stat stat-red">
                    <div class="stat-num">{{ $rechazadas }}</div>
                    <div class="stat-label"> Rechazadas</div>
                </div>
                <div class="stat stat-orange">
                    <div class="stat-num">{{ $solicitudes_hoy }}</div>
                    <div class="stat-label">📊 Solicitudes Hoy</div>
                </div>
            </div>

            <!-- MOVIMIENTOS RECIENTES -->
            <div class="card">
                <div class="card-head">
                    <h3>📝 Movimientos Recientes</h3>
                    <a href="/rh/solicitudes" class="btn btn-blue btn-sm">Ver todas</a>
                </div>
                <div class="card-body">
                    @if(count($movimientos) > 0)
                    <table class="mini-table">
                        <tr><th>Tipo</th><th>Usuario</th><th>Detalle</th><th>Hora</th></tr>
                        @foreach($movimientos as $m)
                        <tr>
                            <td><span class="tag tag-{{ $m->tipo_movimiento }}">{{ ucfirst($m->tipo_movimiento) }}</span></td>
                            <td>{{ $m->usuario_nombre }}</td>
                            <td>{{ Str::limit($m->detalle, 50) }}</td>
                            <td style="font-size:11px;color:var(--neutral-400);">{{ substr($m->created_at, 11, 5) }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <div class="empty">Sin movimientos</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
