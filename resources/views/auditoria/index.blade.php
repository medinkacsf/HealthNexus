<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Auditoria Inmutable - HealthNexus</title>
    <style>
        body { font-family: Arial; background: #f0f4f8; margin: 0; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h1 { color: #2c3e50; margin: 0; font-size: 24px; }
        .btn { padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; font-size: 14px; text-decoration: none; color: white; display: inline-block; }
        .btn-back { background: #7f8c8d; }
        .resumen { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 20px; }
        .tarjeta { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .tarjeta-num { font-size: 32px; font-weight: bold; color: #2c3e50; }
        .tarjeta-label { font-size: 12px; color: #7f8c8d; margin-top: 5px; }
        .tarjeta-rojo .tarjeta-num { color: #e74c3c; }
        .tarjeta-verde .tarjeta-num { color: #27ae60; }
        .tarjeta-azul .tarjeta-num { color: #2980b9; }
        .filtros { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
        .filtros select, .filtros input { padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn-filtrar { background: #2980b9; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .tabla-container { background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2c3e50; color: white; padding: 12px 15px; text-align: left; font-size: 13px; }
        td { padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 13px; }
        tr:hover { background: #f8f9fa; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        .badge-verde { background: #eafaf1; color: #27ae60; }
        .badge-rojo { background: #fdedec; color: #e74c3c; }
        .badge-amarillo { background: #fef9e7; color: #f39c12; }
        .badge-azul { background: #ebf5fb; color: #2980b9; }
        .badge-gris { background: #f4f6f6; color: #7f8c8d; }
        .inmutable { color: #e74c3c; font-weight: bold; font-size: 11px; }
        .paginacion { padding: 15px; text-align: center; }
        .paginacion a { margin: 0 5px; padding: 8px 12px; background: #ecf0f1; border-radius: 5px; text-decoration: none; color: #2c3e50; }
        .paginacion a.active { background: #2c3e50; color: white; }
        .lock-icon { font-size: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔒 Auditoria Inmutable</h1>
        <div>
            <a href="/rh" class="btn btn-back">← Volver a RRHH</a><form action="/logout" method="POST" style="display:inline;margin-left:10px;">@csrf<button type="submit" class="btn btn-back">Salir</button></form>
        </div>
    </div>

    <div class="resumen">
        <div class="tarjeta">
            <div class="tarjeta-num">{{ $resumen['total'] }}</div>
            <div class="tarjeta-label">Total Registros</div>
        </div>
        <div class="tarjeta tarjeta-verde">
            <div class="tarjeta-num">{{ $resumen['logins'] }}</div>
            <div class="tarjeta-label">Logins Exitosos</div>
        </div>
        <div class="tarjeta tarjeta-rojo">
            <div class="tarjeta-num">{{ $resumen['logins_fallidos'] }}</div>
            <div class="tarjeta-label">Logins Fallidos</div>
        </div>
        <div class="tarjeta tarjeta-azul">
            <div class="tarjeta-num">{{ $resumen['registros'] }}</div>
            <div class="tarjeta-label">Nuevos Usuarios</div>
        </div>
        <div class="tarjeta">
            <div class="tarjeta-num">{{ $resumen['hoy'] }}</div>
            <div class="tarjeta-label">Actividad Hoy</div>
        </div>
    </div>

    <form method="GET" action="{{ route('auditoria.panel') }}" class="filtros">
        <label><strong>Filtrar:</strong></label>
        <select name="tipo">
            <option value="">Todos los tipos</option>
            <option value="login" {{ request('tipo') == 'login' ? 'selected' : '' }}>Login Exitoso</option>
            <option value="login_fallido" {{ request('tipo') == 'login_fallido' ? 'selected' : '' }}>Login Fallido</option>
            <option value="logout" {{ request('tipo') == 'logout' ? 'selected' : '' }}>Logout</option>
            <option value="registro" {{ request('tipo') == 'registro' ? 'selected' : '' }}>Registro</option>
            <option value="navegacion" {{ request('tipo') == 'navegacion' ? 'selected' : '' }}>Navegacion</option>
        </select>
        <input type="date" name="fecha" value="{{ request('fecha') }}">
        <button type="submit" class="btn-filtrar">🔍 Filtrar</button>
        <a href="{{ route('auditoria.panel') }}" style="color:#e74c3c; text-decoration:none; font-size:13px;">Limpiar filtros</a>
    </form>

    <div class="tabla-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha/Hora</th>
                    <th>Usuario</th>
                    <th>IP</th>
                    <th>Tipo</th>
                    <th>Accion</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td><span class="lock-icon">🔒</span> {{ $log->id }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($log->created_at)) }}</td>
                    <td>
                        @if($log->usuario_nombre)
                            <strong>{{ $log->usuario_nombre }}</strong><br>
                            <small style="color:#888;">{{ $log->usuario_email }}</small>
                        @else
                            <span style="color:#e74c3c;">No identificado</span>
                        @endif
                    </td>
                    <td><code>{{ $log->ip_address }}</code></td>
                    <td>
                        @switch($log->tipo)
                            @case('login')
                                <span class="badge badge-verde">LOGIN</span>
                                @break
                            @case('login_fallido')
                                <span class="badge badge-rojo">FALLIDO</span>
                                @break
                            @case('logout')
                                <span class="badge badge-amarillo">LOGOUT</span>
                                @break
                            @case('registro')
                                <span class="badge badge-azul">REGISTRO</span>
                                @break
                            @default
                                <span class="badge badge-gris">{{ strtoupper($log->tipo) }}</span>
                        @endswitch
                    </td>
                    <td><code>{{ $log->action }}</code></td>
                    <td>{{ $log->descripcion ?? '-' }}</td>
                    <td>
                        @if($log->exitoso)
                            <span class="badge badge-verde">OK</span>
                        @else
                            <span class="badge badge-rojo">FAIL</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($logs->isEmpty())
            <div style="padding:40px; text-align:center; color:#888;">
                No se encontraron registros con los filtros aplicados.
            </div>
        @endif

        <div class="paginacion">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>

    <div style="margin-top:15px; text-align:center;">
        <span class="inmutable">🔒 REGISTROS INMUTABLES - Estos datos no pueden ser modificados ni eliminados por ningun usuario</span>
    </div>
</body>
</html>
