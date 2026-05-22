<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósitos - RRHH</title>
    <style>
        :root { --primary:#1e3a5f;--primary-light:#2c5282;--blue-50:#ebf8ff;--blue-600:#3182ce;--green-50:#f0fff4;--green-100:#c6f6d5;--green-600:#38a169;--red-50:#fff5f5;--red-100:#fed7d7;--red-600:#e53e3e;--orange-50:#fffaf0;--orange-100:#feebc8;--orange-600:#dd6b20;--neutral-50:#f7fafc;--neutral-100:#e2e8f0;--neutral-200:#cbd5e0;--neutral-400:#a0aec0;--neutral-600:#718096;--neutral-800:#2d3748;--radius-md:8px;--radius-lg:12px; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--neutral-50);height:100vh;display:flex;flex-direction:column;color:var(--neutral-800)}
        .header{background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:18px;font-weight:600}
        .header-right{display:flex;gap:12px;align-items:center;font-size:13px}
        .btn{padding:8px 16px;border-radius:var(--radius-md);border:none;cursor:pointer;font-size:12px;font-weight:500;text-decoration:none;color:white}
        .btn-logout{background:rgba(255,255,255,0.15)}.btn-green{background:var(--green-600)}.btn-blue{background:var(--blue-600)}.btn-orange{background:var(--orange-600)}.btn-red{background:var(--red-600)}.btn-sm{padding:6px 12px;font-size:11px}
        .main{display:flex;flex:1;overflow:hidden}
        .sidebar{width:250px;background:white;padding:20px 0;overflow-y:auto;border-right:1px solid var(--neutral-200)}
        .sidebar-section{padding:0 16px;margin-bottom:20px}
        .sidebar-title{font-size:10px;color:var(--neutral-400);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px;font-weight:600}
        .nav-item{padding:10px 12px;margin:2px 0;border-radius:var(--radius-md);display:flex;align-items:center;gap:10px;font-size:13px;text-decoration:none;color:var(--neutral-600);border-left:3px solid transparent}
        .nav-item:hover{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600)}
        .nav-item.active{background:var(--blue-50);color:var(--blue-600);border-left-color:var(--blue-600);font-weight:600}
        .nav-icon{width:20px;text-align:center;font-size:14px}
        .content{flex:1;padding:24px;overflow-y:auto}
        .summary{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px}
        .summary-card{background:white;border-radius:var(--radius-lg);padding:16px 20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100)}
        .summary-card.orange{border-top:3px solid var(--orange-600)}.summary-card.blue{border-top:3px solid var(--blue-600)}.summary-card.green{border-top:3px solid var(--green-600)}
        .summary-label{font-size:10px;color:var(--neutral-400);text-transform:uppercase;font-weight:600;margin-bottom:4px}
        .summary-value{font-size:20px;font-weight:700}
        .card{background:white;border-radius:var(--radius-lg);box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid var(--neutral-100);overflow:hidden}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center;background:var(--neutral-50)}
        .card-header h3{font-size:14px;font-weight:600}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 12px;text-align:left;font-size:10px;color:var(--neutral-400);text-transform:uppercase;background:var(--neutral-50);border-bottom:1px solid var(--neutral-100)}
        td{padding:10px 12px;font-size:12px;border-bottom:1px solid var(--neutral-50)}
        tr:hover td{background:var(--neutral-50)}
        .tag{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:600;display:inline-block}
        .tag-depositado{background:var(--orange-100);color:var(--orange-600)}.tag-liberado{background:var(--green-100);color:var(--green-600)}.tag-aplicado{background:var(--blue-100);color:var(--blue-600)}.tag-devuelto{background:var(--red-100);color:var(--red-600)}
        .pagination{padding:12px 20px;display:flex;gap:4px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;border:1px solid var(--neutral-200)}
        .pagination .active{background:var(--blue-600);color:white;border-color:var(--blue-600)}
        .alert{padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;font-size:13px}
        .alert-success{background:var(--green-50);color:var(--green-600);border:1px solid var(--green-100)}
        .modal-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:100;justify-content:center;align-items:center}
        .modal-overlay.active{display:flex}
        .modal{background:white;border-radius:var(--radius-lg);width:450px}
        .modal-head{padding:16px 20px;border-bottom:1px solid var(--neutral-100);display:flex;justify-content:space-between;align-items:center}
        .modal-head h3{font-size:15px;font-weight:600}
        .modal-body{padding:20px}
        .modal-body label{display:block;font-size:12px;font-weight:600;margin-bottom:6px;color:var(--neutral-600)}
        .modal-body textarea{width:100%;padding:10px 12px;border:1px solid var(--neutral-200);border-radius:var(--radius-md);font-size:13px;min-height:80px;resize:vertical}
        .modal-foot{padding:14px 20px;border-top:1px solid var(--neutral-100);display:flex;gap:8px;justify-content:flex-end}
        .btn-dark{background:var(--neutral-600)}
        .acciones{display:flex;gap:4px}
    </style>
</head>
<body>
    <div class="header">
        <h1> Liberar Depósitos</h1>
        <div class="header-right">
            <a href="/rh/depositos/nuevo" class="btn btn-green btn-sm">+ Nuevo Depósito</a>
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-logout"> Salir</button></form>
        </div>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section"><div class="sidebar-title">Principal</div><a href="/rh" class="nav-item"><span class="nav-icon"></span> Dashboard</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Pacientes</div><a href="/rh/cuentas-pacientes" class="nav-item"><span class="nav-icon"></span> Cuentas Pacientes</a><a href="/rh/presupuestos" class="nav-item"><span class="nav-icon"></span> Presupuestos</a><a href="/rh/pago-servicios" class="nav-item"><span class="nav-icon"></span> Pago de Servicios</a><a href="/rh/corte-caja" class="nav-item"><span class="nav-icon"> Macy</span> Corte de Caja</a><a href="/rh/depositos" class="nav-item active"><span class="nav-icon"></span> Liberar Depósitos</a></div>
            <div class="sidebar-section"><div class="sidebar-title">Sistema</div><a href="/auditoria" class="nav-item"><span class="nav-icon"></span> Auditoría</a></div>
        </div>
        <div class="content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="summary">
                <div class="summary-card orange"><div class="summary-label"> Pendientes</div><div class="summary-value" style="color:var(--orange-600);">{{ $pendientes }}</div></div>
                <div class="summary-card blue"><div class="summary-label"> Monto por Liberar</div><div class="summary-value" style="color:var(--blue-600);">${{ number_format($montoPendiente, 2) }}</div></div>
                <div class="summary-card green"><div class="summary-label"> Total Depósitos</div><div class="summary-value" style="color:var(--green-600);">{{ $depositos->total() }}</div></div>
            </div>
            <div class="card">
                <div class="card-header"><h3> Todos los Depósitos</h3></div>
                <table>
                    <tr><th>ID</th><th>Paciente</th><th>Monto</th><th>Concepto</th><th>Método</th><th>Fecha Depósito</th><th>Estado</th><th>Acciones</th></tr>
                    @foreach($depositos as $d)
                    <tr>
                        <td><strong>#{{ $d->id }}</strong></td>
                        <td>{{ Str::limit($d->paciente_nombre, 25) }}</td>
                        <td style="font-weight:700;">${{ number_format($d->monto, 2) }}</td>
                        <td style="font-size:11px;">{{ Str::limit($d->concepto, 30) }}</td>
                        <td style="font-size:11px;">{{ ucfirst($d->metodo_pago ?? '—') }}</td>
                        <td style="font-size:11px;">{{ $d->fecha_deposito }}</td>
                        <td><span class="tag tag-{{ $d->estado }}">{{ ucfirst($d->estado) }}</span></td>
                        <td>
                            @if($d->estado == 'depositado')
                            <div class="acciones">
                                <a href="/rh/depositos/aplicar/{{ $d->id }}" class="btn btn-green btn-sm" title="Aplicar a cuenta"></a>
                                <button onclick="mostrarLiberar({{ $d->id }})" class="btn btn-orange btn-sm" title="Liberar"></button>
                            </div>
                            @else
                            <span style="font-size:11px;color:var(--neutral-400);">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="pagination">{{ $depositos->links() }}</div>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="modalLiberar">
        <div class="modal">
            <div class="modal-head"><h3> Liberar Depósito #<span id="libId"></span></h3><button onclick="cerrarModal()" style="background:none;border:none;font-size:18px;cursor:pointer;">×</button></div>
            <form method="POST" id="formLiberar">
                @csrf
                <div class="modal-body">
                    <label>Motivo de liberación *</label>
                    <textarea name="motivo_liberacion" placeholder="Explique por qué se libera este depósito..." required></textarea>
                </div>
                <div class="modal-foot">
                    <button type="button" onclick="cerrarModal()" class="btn btn-dark">Cancelar</button>
                    <button type="submit" class="btn btn-orange"> Liberar</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function mostrarLiberar(id) {
            document.getElementById('libId').textContent = id;
            document.getElementById('formLiberar').action = '/rh/depositos/liberar/' + id;
            document.getElementById('modalLiberar').classList.add('active');
        }
        function cerrarModal() { document.getElementById('modalLiberar').classList.remove('active'); }
    </script>
</body>
</html>
