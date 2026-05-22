<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Anomalías - RRHH</title>
    <style>
        :root {
            --red-50: #FFF0F0; --red-100: #FFCDD0; --red-400: #E03B42; --red-600: #B01E25;
            --blue-50: #EBF4FF; --blue-400: #2F7EF5; --blue-600: #1456C8;
            --neutral-50: #F7F8FA; --neutral-200: #D8DAE2; --neutral-400: #9096A8;
            --neutral-600: #565C70; --neutral-800: #2A2E3D;
            --color-surface: #ffffff; --color-bg: var(--neutral-50);
            --font-sans: 'Segoe UI', system-ui, sans-serif;
            --radius-sm: 4px; --radius-md: 8px; --radius-lg: 14px; --radius-pill: 999px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-sans); background: var(--color-bg); height: 100vh; display: flex; flex-direction: column; color: var(--neutral-800); }
        .header { background: linear-gradient(135deg, var(--red-600), var(--red-400)); color: white; padding: 14px 28px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; }
        .header-info { display: flex; gap: 12px; align-items: center; }
        .btn { padding: 8px 16px; border-radius: var(--radius-md); border: none; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; color: white; }
        .btn-outline { background: transparent; border: 2px solid white; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .sidebar { width: 260px; background: var(--color-surface); padding: 20px; overflow-y: auto; border-right: 1px solid var(--neutral-200); }
        .sidebar h3 { color: var(--neutral-600); margin-bottom: 16px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .nav-item { padding: 11px 14px; margin-bottom: 3px; border-radius: var(--radius-md); cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 13px; text-decoration: none; color: var(--neutral-600); border-left: 3px solid transparent; }
        .nav-item:hover { background: var(--blue-50); color: var(--blue-600); border-left-color: var(--blue-400); }
        .nav-item.active { background: var(--red-50); color: var(--red-600); border-left-color: var(--red-400); font-weight: 600; }
        .content { flex: 1; padding: 24px; overflow-y: auto; }
        .card { background: var(--color-surface); border-radius: var(--radius-lg); box-shadow: 0 1px 4px rgba(0,0,0,0.04); margin-bottom: 20px; border: 1px solid var(--neutral-200); overflow: hidden; }
        .card-head { padding: 14px 20px; border-bottom: 1px solid var(--neutral-200); display: flex; justify-content: space-between; align-items: center; background: var(--red-50); }
        .card-head h3 { font-size: 14px; font-weight: 600; color: var(--red-600); }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 11px; color: var(--neutral-400); text-transform: uppercase; border-bottom: 2px solid var(--neutral-200); background: var(--neutral-50); }
        .table td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--neutral-200); }
        .table tr:last-child td { border-bottom: none; }
        .tag { padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; }
        .tag-revision { background: #fff3cd; color: #856404; }
        .tag-estupefaciente { background: var(--red-100); color: var(--red-600); }
        .tag-excesivo { background: var(--red-100); color: var(--red-600); }
        .tag-duplicado { background: var(--blue-100); color: var(--blue-600); }
        .anomalia-card { padding: 16px; border-left: 4px solid var(--red-400); background: var(--red-50); border-radius: 0 var(--radius-md) var(--radius-md) 0; margin-bottom: 12px; }
        .anomalia-card h4 { color: var(--red-600); font-size: 13px; margin-bottom: 4px; }
        .anomalia-card p { color: var(--neutral-600); font-size: 12px; }
        .empty { padding: 40px; text-align: center; color: var(--neutral-400); }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚨 Anomalías Detectadas por IA</h1>
        <div class="header-info">
            <span>{{ auth()->user()->name }}</span>
            <a href="/rh" class="btn btn-outline">← Dashboard</a>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <h3>Menú RRHH</h3>
            <a href="/rh" class="nav-item"><span>📊</span> Dashboard</a>
            <a href="/rh/solicitudes" class="nav-item"><span></span> Solicitudes</a>
            <a href="/rh/anomalias" class="nav-item active"><span>🚨</span> Anomalías</a>
            <a href="/auditoria" class="nav-item"><span>🔒</span> Auditoría</a>
        </div>

        <div class="content">
            @if(session('success'))
            <div style="padding:12px 16px;background:var(--blue-50);border:1px solid var(--blue-100);border-radius:8px;color:var(--blue-600);margin-bottom:16px;">{{ session('success') }}</div>
            @endif

            @if(count($anomalias) > 0)
            <div class="card">
                <div class="card-head">
                    <h3>🚨 {{ count($anomalias) }} anomalías pendientes de revisión</h3>
                <form action="/rh/detectar-anomalias" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red btn-sm">🔄 Re-analizar</button></form>
            </div>
            <div class="card-body">
                @foreach($anomalias as $a)
                <div class="anomalia-card">
                    <h4>{{ $a->anomaly_tipo }}</h4>
                    <p><strong>{{ $a->descripcion }}</strong></p>
                    <p>{{ $a->anomaly_detalle }}</p>
                    <p style="margin-top:4px;font-size:11px;"><strong>Solicitante:</strong> {{ $a->solicitante_nombre }} | <strong>Costo:</strong> ${{ number_format($a->costo_solicitado, 2) }} | <strong>Estado:</strong> {{ ucfirst($a->estado) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty">No hay anomalías pendientes</div>
            @endif
        </div>
    </div>
</body>
</html>
