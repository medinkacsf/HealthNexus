<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Presupuesto - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-outline{background:transparent;border:1.5px solid rgba(255,255,255,0.5)}
        .btn-green{background:var(--green-600)}.btn-orange{background:var(--orange-600)}.btn-red{background:var(--red-600)}.btn-blue{background:var(--blue-600)}.btn-dark{background:var(--neutral-600)}.btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;margin-bottom:20px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:20px}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-enviado{background:var(--orange-100);color:var(--orange-600)}.tag-aprobado{background:var(--green-100);color:var(--green-600)}.tag-borrador{background:var(--neutral-100);color:var(--neutral-600)}.tag-rechazado{background:var(--red-100);color:var(--red-600)}
        .totals-box{background:var(--neutral-50);padding:16px;border-radius:var(--radius-md)}
        .totals-row{display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px}
        .totals-row.total{font-size:18px;font-weight:700;color:var(--blue-600);border-top:2px solid var(--neutral-200);padding-top:8px;margin-top:8px;margin-bottom:0}
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:13px}
        .info-grid label{color:var(--neutral-400);font-size:11px}
        .acciones{display:flex;gap:8px;margin-top:16px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Presupuesto {{ $presupuesto->codigo }}</h1>
        <div class="header-right">
            <span class="tag tag-{{ $presupuesto->estado }}" style="font-size:12px;padding:6px 14px;">{{ ucfirst($presupuesto->estado) }}</span>
            <a href="/rh/presupuestos" class="btn btn-outline">← Volver</a>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout">🚪 Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon">💳</span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item active"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon">💰</span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon">🔒</span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon">🔐</span> Auditoría</a></div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-header"><h3>👤 Información del Paciente</h3></div>
                <div class="card-body">
                    <div class="info-grid">
                        <div><label>Paciente</label><div><strong>{{ $presupuesto->paciente_nombre }}</strong></div></div>
                        <div><label>Contacto</label><div>{{ $presupuesto->paciente_contacto ?? '—' }}</div></div>
                        <div><label>Tipo</label><div>{{ ucfirst($presupuesto->tipo_paciente) }}</div></div>
                        <div><label>Médico</label><div>{{ $presupuesto->medico_nombre ?? 'No asignado' }}</div></div>
                        <div><label>Validez</label><div>{{ $presupuesto->validez_dias }} días</div></div>
                        <div><label>Fecha</label><div>{{ substr($presupuesto->created_at, 0, 10) }}</div></div>
                    </div>
                    @if($presupuesto->notas)
                    <div style="margin-top:12px;padding:10px;background:var(--neutral-50);border-radius:6px;font-size:12px;color:var(--neutral-600);">
                        <strong>Notas:</strong> {{ $presupuesto->notas }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3> Servicios Cotizados</h3></div>
                <table>
                    <tr><th>Código</th><th>Servicio</th><th>Cantidad</th><th>P. Unitario</th><th style="text-align:right;">Subtotal</th></tr>
                    @foreach($detalles as $d)
                    <tr>
                        <td>{{ $d->servicio_codigo ?? '—' }}</td>
                        <td>{{ $d->servicio_nombre }}</td>
                        <td>{{ $d->cantidad }}</td>
                        <td>${{ number_format($d->precio_unitario, 2) }}</td>
                        <td style="text-align:right;font-weight:600;">${{ number_format($d->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </table>
                <div style="padding:0 20px 20px;">
                    <div class="totals-box">
                        <div class="totals-row"><span>Subtotal:</span><span>${{ number_format($presupuesto->subtotal, 2) }}</span></div>
                        @if($presupuesto->descuento_porcentaje > 0)
                        <div class="totals-row" style="color:var(--red-600);"><span>Descuento ({{ $presupuesto->descuento_porcentaje }}%):</span><span>-${{ number_format($presupuesto->descuento_monto, 2) }}</span></div>
                        @endif
                        <div class="totals-row total"><span>TOTAL:</span><span>${{ number_format($presupuesto->total, 2) }}</span></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3>⚙ Cambiar Estado</h3></div>
                <div class="card-body">
                    <div class="acciones">
                        <form method="POST" action="/rh/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf
                            <input type="hidden" name="estado" value="borrador"><button type="submit" class="btn btn-dark btn-sm">📝 Borrador</button>
                        </form>
                        <form method="POST" action="/rh/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf
                            <input type="hidden" name="estado" value="enviado"><button type="submit" class="btn btn-orange btn-sm"> Enviar</button>
                        </form>
                        <form method="POST" action="/rh/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf
                            <input type="hidden" name="estado" value="aprobado"><button type="submit" class="btn btn-green btn-sm"> Aprobar</button>
                        </form>
                        <form method="POST" action="/rh/presupuestos/estado/{{ $presupuesto->id }}" style="display:inline;">@csrf
                            <input type="hidden" name="estado" value="rechazado"><button type="submit" class="btn btn-red btn-sm"> Rechazar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
