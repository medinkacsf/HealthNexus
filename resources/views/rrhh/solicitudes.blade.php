<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes - RRHH</title>
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
        .btn-dark { background: var(--neutral-800); }
        .btn-blue { background: var(--blue-600); }
        .btn-outline { background: transparent; border: 2px solid white; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .sidebar { width: 260px; background: var(--color-surface); padding: 20px; overflow-y: auto; border-right: 1px solid var(--neutral-200); }
        .sidebar h3 { color: var(--neutral-600); margin-bottom: 16px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .nav-item { padding: 11px 14px; margin-bottom: 3px; border-radius: var(--radius-md); cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 13px; text-decoration: none; color: var(--neutral-600); border-left: 3px solid transparent; }
        .nav-item:hover { background: var(--blue-50); color: var(--blue-600); border-left-color: var(--blue-400); }
        .nav-item.active { background: var(--red-50); color: var(--red-600); border-left-color: var(--red-400); font-weight: 600; }
        .content { flex: 1; padding: 24px; overflow-y: auto; }
        .card { background: var(--color-surface); border-radius: var(--radius-lg); box-shadow: 0 1px 4px rgba(0,0,0,0.04); margin-bottom: 20px; border: 1px solid var(--neutral-200); overflow: hidden; }
        .card-head { padding: 14px 20px; border-bottom: 1px solid var(--neutral-200); display: flex; justify-content: space-between; align-items: center; background: var(--neutral-50); }
        .card-head h3 { font-size: 14px; font-weight: 600; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 11px; color: var(--neutral-400); text-transform: uppercase; border-bottom: 2px solid var(--neutral-200); background: var(--neutral-50); }
        .table td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--neutral-200); vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover { background: var(--blue-50); }
        .tag { padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; display: inline-block; }
        .tag-pendiente { background: var(--blue-100); color: var(--blue-600); }
        .tag-aprobada { background: #d4edda; color: #155724; }
        .tag-rechazada { background: var(--red-100); color: var(--red-600); }
        .tag-revision { background: #fff3cd; color: #856404; }
        .tag-servicio { background: var(--blue-100); color: var(--blue-600); }
        .tag-medicamento { background: var(--red-100); color: var(--red-600); }
        .tag-procedimiento { background: #e8daef; color: #6c3483; }
        .anomalia-row { background: var(--red-50) !important; }
        .anomalia-row td { background: var(--red-50) !important; }
        .acciones { display: flex; gap: 6px; }
        .btn-sm { padding: 5px 12px; font-size: 11px; border-radius: var(--radius-sm); border: none; cursor: pointer; font-weight: 500; color: white; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: var(--color-surface); border-radius: var(--radius-lg); width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal-head { padding: 16px 20px; border-bottom: 1px solid var(--neutral-200); display: flex; justify-content: space-between; align-items: center; }
        .modal-head h3 { font-size: 16px; font-weight: 600; }
        .modal-body { padding: 20px; }
        .modal-body textarea { width: 100%; padding: 10px 14px; border: 2px solid var(--neutral-200); border-radius: var(--radius-md); font-size: 13px; font-family: var(--font-sans); resize: vertical; min-height: 80px; outline: none; }
        .modal-body textarea:focus { border-color: var(--blue-400); }
        .modal-foot { padding: 12px 20px; border-top: 1px solid var(--neutral-200); display: flex; gap: 8px; justify-content: flex-end; }
        .pagination { padding: 16px; display: flex; justify-content: center; gap: 8px; }
        .pagination a { padding: 6px 14px; background: var(--blue-50); color: var(--blue-600); border-radius: var(--radius-md); text-decoration: none; font-size: 13px; }
        .pagination a:hover { background: var(--blue-100); }
        .pagination a.active { background: var(--blue-400); color: white; }
        .pagination span { padding: 6px 14px; color: var(--neutral-400); }
    </style>
</head>
<body>
    <div class="header">
        <h1> Solicitudes de Autorización</h1>
        <div class="header-info">
            <span class="badge">{{ $user->name }}</span>
            <a href="/rh" class="btn btn-outline">← Dashboard</a>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <h3>Menú RRHH</h3>
            <a href="/rh" class="nav-item"><span>📊</span> Dashboard</a>
            <a href="/rh/solicitudes" class="nav-item active"><span></span> Solicitudes</a>
            <a href="/rh/anomalias" class="nav-item"><span>🚨</span> Anomalías</a>
            <a href="/auditoria" class="nav-item"><span>🔒</span> Auditoría</a>
        </div>

        <div class="content">
            @if(session('success'))
            <div style="padding:12px 16px;background:#d4edda;border:1px solid #27ae60;border-radius:8px;color:#155724;margin-bottom:16px;">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div style="padding:12px 16px;background:var(--red-50);border:1px solid var(--red-100);border-radius:8px;color:var(--red-600);margin-bottom:16px;">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-head">
                    <h3> Todas las Solicitudes ({{ $solicitudes->total() }})</h3>
                    <form action="/rh/detectar-anomalias" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red btn-sm">🔍 Detectar Anomalías IA</button></form>
                </div>
                <div class="card-body">
                    @if($solicitudes->count() > 0)
                    <table class="table">
                        <tr><th>ID</th><th>Fecha</th><th>Solicitante</th><th>Tipo</th><th>Descripción</th><th>Costo</th><th>Estado</th><th>Acciones</th></tr>
                        @foreach($solicitudes as $s)
                        <tr @if($s->anomalia_detectada) class="anomalia-row" @endif>
                            <td><strong>#{{ $s->id }}</strong></td>
                            <td style="font-size:11px;color:var(--neutral-400);">{{ substr($s->created_at, 0, 10) }}</td>
                            <td>{{ $s->solicitante_nombre }}</td>
                            <td><span class="tag tag-{{ $s->tipo_solicitud }}">{{ ucfirst($s->tipo_solicitud) }}</span></td>
                            <td>{{ Str::limit($s->descripcion, 40) }}</td>
                            <td><strong>${{ number_format($s->costo_solicitado, 2) }}</strong></td>
                            <td>
                                <span class="tag tag-{{ $s->estado }}">{{ ucfirst($s->estado) }}</span>
                                @if($s->anomalia_detectada)
                                    <br><span class="tag tag-revision" style="margin-top:2px;">⚠ {{ $s->anomaly_tipo }}</span>
                                @endif
                            </td>
                            <td class="acciones">
                                @if($s->estado == 'pendiente' || $s->estado == 'en_revision')
                                    <a href="/rh/aprobar/{{ $s->id }}" class="btn-sm" style="background:#27ae60;"></a>
                                    <button onclick="mostrarModal({{ $s->id }})" class="btn-sm" style="background:var(--red-600);"></button>
                                @else
                                    <span style="font-size:11px;color:var(--neutral-400);">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="pagination">{{ $solicitudes->withQueryString(['sort' => 'id', 'direction' => 'desc'])->links() }}</div>
                    @else
                    <div style="padding:40px;text-align:center;color:var(--neutral-400);">Sin solicitudes</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RECHAZO -->
    <div class="modal-overlay" id="modalRechazo">
        <div class="modal">
            <div class="modal-head">
                <h3> Rechazar Solicitud #<span id="modalId"></span></h3>
                <button onclick="cerrarModal()" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--neutral-400);">×</button>
            </div>
            <form method="POST" id="formRechazo">
                @csrf
                <input type="hidden" name="solicitud_id" id="solicitudId" value="">
                <div class="modal-body">
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Motivo del rechazo *</label>
                    <textarea name="comentarios" placeholder="Explique por qué se rechaza..." required></textarea>
                </div>
                <div class="modal-foot">
                    <button type="button" onclick="cerrarModal()" class="btn btn-dark">Cancelar</button>
                    <button type="submit" class="btn btn-red">Rechazar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarModal(id) {
            document.getElementById('solicitudId').value = id;
            document.getElementById('modalId').textContent = id;
            document.getElementById('modalRechazo').classList.add('active');
        }
        function cerrarModal() {
            document.getElementById('modalRechazo').classList.remove('active');
        }
    </script>
</body>
</html>
