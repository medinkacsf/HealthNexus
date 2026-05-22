<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cuenta - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-outline{background:transparent;border:1.5px solid rgba(255,255,255,0.5)}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .summary{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .summary-card{background:white;border-radius:var(--radius-lg);padding:16px 20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);text-align:center}
        .summary-card.blue{border-top:3px solid var(--blue-600)}.summary-card.green{border-top:3px solid var(--green-600)}.summary-card.red{border-top:3px solid var(--red-600)}.summary-card.orange{border-top:3px solid var(--orange-600)}
        .summary-label{font-size:10px;color:var(--neutral-400);text-transform:uppercase;font-weight:600;margin-bottom:6px}
        .summary-value{font-size:20px;font-weight:700}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;margin-bottom:20px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-abierta{background:var(--blue-100);color:var(--blue-600)}.tag-pagada{background:var(--green-100);color:var(--green-600)}.tag-vencida{background:var(--red-100);color:var(--red-600)}
        .empty{padding:20px;text-align:center;color:var(--neutral-400);font-size:13px}
    </style>
</head>
<body>
    <div class="header">
        <h1>💳 Cuenta #{{ $cuenta->id }} - {{ $cuenta->paciente_nombre }}</h1>
        <div class="header-right"><a href="/rh/cuentas-pacientes" class="btn btn-outline">← Volver</a><form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form></div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item active"><span class="nav-icon">💳</span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            <div class="summary">
                <div class="summary-card blue"><div class="summary-label">Cargo Total</div><div class="summary-value" style="color:var(--blue-600);">${{ number_format($cuenta->total_cargo, 2) }}</div></div>
                <div class="summary-card green"><div class="summary-label">Total Abonado</div><div class="summary-value" style="color:var(--green-600);">${{ number_format($cuenta->total_abono, 2) }}</div></div>
                <div class="summary-card red"><div class="summary-label">Saldo Pendiente</div><div class="summary-value" style="color:{{ $cuenta->saldo_pendiente > 0 ? 'var(--red-600)' : 'var(--green-600)' }};">${{ number_format($cuenta->saldo_pendiente, 2) }}</div></div>
                <div class="summary-card orange"><div class="summary-label">Estado</div><div class="summary-value" style="font-size:16px;"><span class="tag tag-{{ $cuenta->estado }}">{{ ucfirst($cuenta->estado) }}</span></div></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div class="card"><div class="card-header"><h3>ℹ Información</h3></div>
                    <div style="padding:16px;font-size:13px;">
                        <p><strong>Paciente:</strong> {{ $cuenta->paciente_nombre }}</p>
                        <p><strong>Médico:</strong> {{ $cuenta->medico_nombre ?? 'No asignado' }}</p>
                        <p><strong>Expediente:</strong> {{ $cuenta->expediente_id ?? 'Sin expediente' }}</p>
                        <p><strong>Apertura:</strong> {{ $cuenta->fecha_apertura }}</p>
                        <p><strong>Último pago:</strong> {{ $cuenta->fecha_ultimo_pago ?? 'Sin pagos' }}</p>
                    </div>
                </div>
                <div class="card"><div class="card-header"><h3>📊 Resumen</h3></div>
                    <div style="padding:16px;font-size:13px;">
                        <p><strong>Total pagos:</strong> {{ count($pagos) }}</p>
                        <p><strong>Saldo pendiente:</strong> <span style="color:{{ $cuenta->saldo_pendiente > 0 ? 'var(--red-600)' : 'var(--green-600)' }};">${{ number_format($cuenta->saldo_pendiente, 2) }}</span></p>
                        <p><strong>Porcentaje pagado:</strong> {{ $cuenta->total_cargo > 0 ? round(($cuenta->total_abono / $cuenta->total_cargo) * 100, 1) : 0 }}%</p>
                        <div style="margin-top:8px;height:8px;background:var(--neutral-100);border-radius:4px;overflow:hidden;">
                            <div style="height:100%;width:{{ $cuenta->total_cargo > 0 ? min(100, ($cuenta->total_abono / $cuenta->total_cargo) * 100) : 0 }}%;background:var(--green-600);border-radius:4px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3>💰 Historial de Pagos</h3></div>
                <table>
                    <tr><th>Fecha</th><th>Folio</th><th>Método</th><th>Concepto</th><th>Referencia</th><th style="text-align:right;">Monto</th></tr>
                    @if(count($pagos) > 0)
                    @foreach($pagos as $p)
                    <tr>
                        <td>{{ substr($p->created_at, 0, 16) }}</td>
                        <td><strong>{{ $p->recibo_folio }}</strong></td>
                        <td>{{ ucfirst($p->metodo_pago) }}</td>
                        <td>{{ $p->concepto }}</td>
                        <td style="font-size:11px;color:var(--neutral-400);">{{ $p->referencia ?? '—' }}</td>
                        <td style="text-align:right;font-weight:600;color:var(--green-600);">${{ number_format($p->monto, 2) }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="6" class="empty">Sin pagos registrados</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</body>
</html>
