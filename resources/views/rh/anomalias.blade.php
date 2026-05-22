<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anomalías IA - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-400:#fc8181;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--red-600),var(--red-400));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}.header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.2)}.btn-red{background:var(--red-600)}.btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--red-50);color:var(--red-600);border-left-color:var(--red-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .anomalia-card{background:white;border-radius:var(--radius-lg);padding:16px 20px;margin-bottom:12px;border-left:4px solid var(--red-400);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);border-left:4px solid var(--red-400)}
        .anomalia-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
        .anomalia-tipo{font-size:13px;font-weight:600;color:var(--red-600)}
        .anomalia-desc{font-size:13px;color:var(--neutral-800);margin-bottom:6px}
        .anomalia-detail{font-size:12px;color:var(--neutral-600);margin-bottom:8px}
        .anomalia-meta{font-size:11px;color:var(--neutral-400)}
        .anomalia-meta strong{color:var(--neutral-600)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-en_revision{background:var(--orange-100);color:var(--orange-600)}.tag-pendiente{background:var(--blue-100);color:var(--blue-600)}
        .empty{padding:40px;text-align:center;color:var(--neutral-400);font-size:14px}
        .scan-btn{background:white;color:var(--red-600);border:2px solid var(--red-600);margin-bottom:16px}
        .scan-btn:hover{background:var(--red-600);color:white}
    </style>
</head>
<body>
    <div class="header">
        <h1>🚨 Anomalías Detectadas por IA</h1>
        <div class="header-right"><span>{{ auth()->user()->name }}</span><form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form></div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon">💳</span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon">📨</span> Solicitudes</a><a href="/rh/anomalias" class="nav-item active"><span class="nav-icon">🚨</span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <form action="/rh/detectar-anomalias" method="POST" style="display:inline;">@csrf<button type="submit" class="btn scan-btn">🔄 Ejecutar Análisis IA</button></form>
            @if(count($anomalias) > 0)
            <div style="font-size:13px;color:var(--neutral-600);margin-bottom:12px;"><strong>{{ count($anomalias) }}</strong> anomalías pendientes</div>
            @foreach($anomalias as $a)
            <div class="anomalia-card">
                <div class="anomalia-header"><span class="anomalia-tipo">⚠ {{ $a->anomalia_tipo ?? 'No especificada' }}</span><span class="tag tag-{{ $a->estado }}">{{ ucfirst($a->estado) }}</span></div>
                <div class="anomalia-desc"><strong>{{ $a->descripcion }}</strong></div>
                <div class="anomalia-detail">{{ $a->anomalia_detalle ?? 'Sin detalle' }}</div>
                <div class="anomalia-meta"><strong>Solicitante:</strong> {{ $a->solicitante_nombre }} | <strong>Costo:</strong> ${{ number_format($a->costo_solicitado, 2) }} | <strong>ID:</strong> #{{ $a->id }}</div>
            </div>
            @endforeach
            @else
            <div class="empty"><div style="font-size:40px;margin-bottom:12px;"></div>No hay anomalías pendientes</div>
            @endif
        </div>
    </div>
</body>
</html>
