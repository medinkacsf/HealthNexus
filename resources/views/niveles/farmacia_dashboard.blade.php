<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Farmacia - HealthNexus</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; margin: 0; }
        .header { background: #2c3e50; color: white; padding: 20px 30px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        
        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #3498db; }
        .stat-card.alert { border-left-color: #e74c3c; }
        .stat-number { font-size: 32px; font-weight: bold; color: #2c3e50; margin: 10px 0; }
        .stat-label { color: #7f8c8d; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }

        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 18px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background: #f8f9fa; color: #555; }
        
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; font-size: 13px; border: none; cursor: pointer; display: inline-block;}
        .btn-primary { background: #3498db; }
        .btn-success { background: #27ae60; }
        .btn-danger { background: #e74c3c; }
        
        .alert-item { padding: 10px; background: #fff5f5; border-left: 4px solid #e74c3c; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .alert-info strong { display: block; color: #c0392b; }
        .alert-info span { font-size: 12px; color: #555; }

        .recipe-box { background: #f9f9f9; padding: 5px; font-family: monospace; font-size: 12px; white-space: pre-wrap; max-width: 300px; }
    </style>
</head>
<body>

<div class="header">
    <div>
        <h1>Módulo de Farmacia</h1>
        <small>Gestión de Recetas e Inventario</small>
    </div>
    <div>
        <a href="/farmacia/inventario" class="btn btn-primary">Ver Inventario Completo</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline-block; margin-left: 15px;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="padding: 8px 15px; border:none; cursor:pointer; color:white; border-radius:4px; font-family: sans-serif;">Cerrar Sesión</button>
                </form>
    </div>
</div>

<!-- PredictAI Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Pendientes de Surtir</div>
        <div class="stat-number">{{ count($pendientes) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Surtidas Hoy</div>
        <div class="stat-number">{{ $surtidasHoy }}</div>
    </div>
    <div class="stat-card alert">
        <div class="stat-label">PredictAI: Stock Crítico</div>
        <div class="stat-number" style="color: #e74c3c;">{{ count($alertasStock) }}</div>
    </div>
</div>

<div class="content-grid">
    <!-- Recetas Pendientes -->
    <div class="card">
        <h2>Recetas Pendientes</h2>
        @if(count($pendientes) > 0)
        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Receta</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendientes as $p)
                <tr>
                    <td>{{ date('H:i', strtotime($p->created_at)) }}</td>
                    <td><strong>{{ $p->paciente_nombre }}</strong></td>
                    <td>{{ $p->medico_nombre }}</td>
                    <td><div class="recipe-box">{{ $p->receta_medica }}</div></td>
                    <td>
                        <a href="/farmacia/surtir/{{ $p->id }}" class="btn btn-primary">Surtir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="text-align: center; padding: 20px; color: #999;">No hay recetas pendientes.</p>
        @endif
    </div>

    <!-- PredictAI Alerts -->
    <div class="card">
        <h2>PredictAI: Alertas de Stock</h2>
        @if(count($alertasStock) > 0)
            @foreach($alertasStock as $alert)
            <div class="alert-item">
                <div class="alert-info">
                    <strong>{{ $alert->nombre_medicamento }}</strong>
                    <span>Stock actual: {{ $alert->existencia }} unidades</span>
                </div>
                <form action="/farmacia/reponer/{{ $alert->id }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="number" name="cantidad" value="10" style="width: 50px; padding: 4px;">
                    <button type="submit" class="btn btn-success" style="font-size: 11px;">Reponer</button>
                </form>
            </div>
            @endforeach
        @else
            <p style="color: green; font-weight: bold; text-align: center;">Stock saludable. Sin alertas.</p>
        @endif

        <h3 style="margin-top: 30px; font-size: 16px;">Actividad Reciente</h3>
        @foreach($surtidas as $s)
        <div style="padding: 8px 0; border-bottom: 1px solid #eee; font-size: 13px;">
            <strong>{{ $s->paciente_nombre }}</strong> <span style="color:#27ae60;">(Dispensado)</span>
            <br><small style="color:#999;">{{ date('H:i', strtotime($s->updated_at)) }}</small>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
