<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de Caja - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--purple-50:#faf5ff;--purple-100:#e9d8fd;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-green{background:var(--green-600)}.btn-dark{background:var(--neutral-600)}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden;margin-bottom:20px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:20px}
        .form-group{margin-bottom:14px}
        .form-group label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .form-group select,.form-group input,.form-group textarea{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px}
        .form-group select:focus,.form-group input:focus{outline:none;border-color:var(--blue-600);box-shadow:0 0 0 3px var(--blue-50)}
        .form-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:16px;padding-top:14px;border-top:1px solid var(--neutral-100)}
        .metodo-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--neutral-100);font-size:13px}
        .metodo-row:last-child{border-bottom:none}
        .metodo-icon{width:30px;height:30px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:14px;margin-right:10px}
        .metodo-icon.efectivo{background:var(--green-100)}.metodo-icon.tarjeta{background:var(--blue-100)}.metodo-icon.transferencia{background:var(--purple-100)}.metodo-icon.seguro{background:var(--orange-100)}
        .total-box{background:var(--blue-50);padding:16px;border-radius:var(--radius-md);text-align:center;margin-top:16px}
        .total-box .label{font-size:11px;color:var(--neutral-400);text-transform:uppercase;font-weight:600}
        .total-box .value{font-size:28px;font-weight:700;color:var(--blue-600);margin-top:4px}
        .status-badge{padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600}
        .status-badge.cerrado{background:var(--green-100);color:var(--green-600)}
        .status-badge.pendiente{background:var(--orange-100);color:var(--orange-600)}
        table{width:100%;border-collapse:collapse}
        th{padding:8px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:8px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .alert-danger{background:var(--red-50);color:var(--red-600);border:1px solid var(--red-100)}
        .empty{padding:20px;text-align:center;color:var(--neutral-400);font-size:12px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Macy Corte de Caja</h1>
        <div class="header-right"><span>{{ auth()->user()->name }}</span><form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form></div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon"></span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon"></span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item active"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item"><span class="nav-icon"></span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3> Turno Matutino</h3>
                        <span class="status-badge {{ $corteMatutino ? 'cerrado' : 'pendiente' }}">{{ $corteMatutino ? ' Cerrado' : '⏳ Pendiente' }}</span>
                    </div>
                    <div class="card-body">
                        @if($corteMatutino)
                        <div style="font-size:12px;margin-bottom:12px;color:var(--neutral-400);">Cajero: {{ $corteMatutino->cajero_nombre }} | Cerrado: {{ $corteMatutino->fecha_cierre }}</div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon efectivo"></span>Efectivo</div><strong>${{ number_format($corteMatutino->total_ingresos_efectivo, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon tarjeta"></span>Tarjeta</div><strong>${{ number_format($corteMatutino->total_ingresos_tarjeta, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon transferencia"></span>Transferencia</div><strong>${{ number_format($corteMatutino->total_ingresos_transferencia, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon seguro"></span>Seguro</div><strong>${{ number_format($corteMatutino->total_ingresos_seguro, 2) }}</strong></div>
                        <div class="total-box"><div class="label">Total del Turno</div><div class="value">${{ number_format($corteMatutino->total_general, 2) }}</div></div>
                        @else
                        <form method="POST" action="/rh/corte-caja/realizar">
                            @csrf
                            <input type="hidden" name="turno" value="matutino">
                            <div class="form-group"><label>Saldo Inicial en Caja *</label><input type="number" step="0.01" min="0" name="saldo_inicial" value="5000" required></div>
                            <div class="form-group"><label>Observaciones</label><textarea name="observaciones" rows="2" placeholder="Notas del turno..."></textarea></div>
                            <div class="form-actions"><button type="submit" class="btn btn-green"> Macy Realizar Corte</button></div>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3> Turno Vespertino</h3>
                        <span class="status-badge {{ $corteVespertino ? 'cerrado' : 'pendiente' }}">{{ $corteVespertino ? ' Cerrado' : '⏳ Pendiente' }}</span>
                    </div>
                    <div class="card-body">
                        @if($corteVespertino)
                        <div style="font-size:12px;margin-bottom:12px;color:var(--neutral-400);">Cajero: {{ $corteVespertino->cajero_nombre }}</div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon efectivo"></span>Efectivo</div><strong>${{ number_format($corteVespertino->total_ingresos_efectivo, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon tarjeta"></span>Tarjeta</div><strong>${{ number_format($corteVespertino->total_ingresos_tarjeta, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon transferencia"></span>Transferencia</div><strong>${{ number_format($corteVespertino->total_ingresos_transferencia, 2) }}</strong></div>
                        <div class="metodo-row"><div style="display:flex;align-items:center;"><span class="metodo-icon seguro"></span>Seguro</div><strong>${{ number_format($corteVespertino->total_ingresos_seguro, 2) }}</strong></div>
                        <div class="total-box"><div class="label">Total del Turno</div><div class="value">${{ number_format($corteVespertino->total_general, 2) }}</div></div>
                        @else
                        <form method="POST" action="/rh/corte-caja/realizar">
                            @csrf
                            <input type="hidden" name="turno" value="vespertino">
                            <div class="form-group"><label>Saldo Inicial en Caja *</label><input type="number" step="0.01" min="0" name="saldo_inicial" required></div>
                            <div class="form-group"><label>Observaciones</label><textarea name="observaciones" rows="2" placeholder="Notas del turno..."></textarea></div>
                            <div class="form-actions"><button type="submit" class="btn btn-green"> Macy Realizar Corte</button></div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3> Resumen del Día</h3></div>
                <table>
                    <tr><th>Fecha</th><th>Turno</th><th>Cajero</th><th>Efectivo</th><th>Tarjeta</th><th>Transferencia</th><th>Seguro</th><th style="text-align:right;">Total</th><th>Estado</th></tr>
                    @if(count($cortesAnteriores) > 0)
                    @foreach($cortesAnteriores as $c)
                    <tr>
                        <td>{{ $c->fecha }}</td>
                        <td>{{ ucfirst($c->turno) }}</td>
                        <td>{{ $c->cajero_nombre }}</td>
                        <td>${{ number_format($c->total_ingresos_efectivo, 2) }}</td>
                        <td>${{ number_format($c->total_ingresos_tarjeta, 2) }}</td>
                        <td>${{ number_format($c->total_ingresos_transferencia, 2) }}</td>
                        <td>${{ number_format($c->total_ingresos_seguro, 2) }}</td>
                        <td style="text-align:right;font-weight:700;">${{ number_format($c->total_general, 2) }}</td>
                        <td><span class="status-badge {{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="9" class="empty">Sin cortes registrados</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</body>
</html>
