<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes Manuales - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-600:#38a169;--red-50:#fff5f5;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--purple-600:#805ad5;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-logout:hover{background:rgba(255,255,255,0.25)}
        .btn-purple{background:var(--purple-600)}.btn-purple:hover{background:#6b46c1}
        .btn-outline{background:transparent;border:1.5px solid var(--neutral-200);color:var(--neutral-600)}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);cursor:pointer;display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;max-width:600px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:20px}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px}
        .form-group textarea{min-height:70px;resize:vertical}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--purple-600);box-shadow:0 0 0 3px var(--purple-50)}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--neutral-100)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-danger{background:var(--red-50);color:var(--red-600);border:1px solid var(--red-100)}
        .alert-warning{background:var(--orange-50);color:var(--orange-600);border:1px solid var(--orange-100)}
        .hint{font-size:10px;color:var(--neutral-400);margin-top:4px}
        .warning-box{background:var(--orange-50);border:1px solid var(--orange-100);border-radius:var(--radius-md);padding:12px 16px;margin-bottom:20px;font-size:12px;color:var(--orange-600)}
        .warning-box strong{display:block;margin-bottom:4px}
    </style>
</head>
<body>
    <div class="header">
        <h1>⚙ Ajustes Manuales</h1>
        <div class="header-right">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Finanzas</div><a href="/rh/cuentas" class="nav-item"><span class="nav-icon">🏦</span> Cuentas</a><a href="/rh/servicios" class="nav-item"><span class="nav-icon"></span> Servicios</a><a href="/rh/movimientos" class="nav-item"><span class="nav-icon"></span> Movimientos</a><a href="/rh/ajustes" class="nav-item active"><span class="nav-icon">⚙</span> Ajustes</a><a href="/rh/reportes" class="nav-item"><span class="nav-icon">📈</span> Reportes</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Operaciones</div><a href="/rh/solicitudes" class="nav-item"><span class="nav-icon">📨</span> Solicitudes</a><a href="/rh/anomalias" class="nav-item"><span class="nav-icon">🚨</span> Anomalías IA</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔒</span> Auditoría</a></div>
        </div>
        <div class="content">
            <div class="warning-box">
                <strong>⚠ Atención</strong>
                Los ajustes manuales quedan registrados en auditoría. Use esta función solo para correcciones o movimientos especiales que no se generan automáticamente.
            </div>

            @if($errors->any())
            <div class="alert alert-danger">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
            @endif

            <div class="card">
                <div class="card-header"><h3>📝 Registrar Ajuste Manual</h3></div>
                <div class="card-body">
                    <form method="POST" action="/rh/ajustes/guardar">
                        @csrf
                        <div class="form-group">
                            <label>Cuenta *</label>
                            <select name="cuenta_id" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentas as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Tipo de Ajuste *</label>
                                <select name="tipo" required>
                                    <option value="ajuste">Ajuste (suma al saldo)</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Monto *</label>
                                <input type="number" step="0.01" min="0.01" name="monto" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Concepto *</label>
                            <input type="text" name="concepto" placeholder="Ej: Ajuste por error de captura" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" placeholder="Detalle del ajuste..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Referencia</label>
                            <input type="text" name="referencia" placeholder="Ej: FOLIO-001, OFICIO-123">
                            <div class="hint">Número de folio, oficio o documento de respaldo</div>
                        </div>
                        <div class="form-actions">
                            <a href="/rh/movimientos" class="btn btn-outline">Cancelar</a>
                            <button type="submit" class="btn btn-purple">💾 Registrar Ajuste</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
