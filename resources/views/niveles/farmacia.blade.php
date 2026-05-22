<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Farmacia - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; }
        .header { background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 13px; }
        .btn-dark { background: #2c3e50; }
        .btn-green { background: #27ae60; }
        .btn-blue { background: #2980b9; }
        .btn-red { background: #e74c3c; }
        .btn-purple { background: #8e44ad; }
        .container { padding: 20px; max-width: 1400px; margin: 0 auto; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; }
        .stat-num { font-size: 36px; font-weight: bold; }
        .stat-label { color: #7f8c8d; font-size: 13px; margin-top: 5px; }
        .stat-amarillo .stat-num { color: #f39c12; }
        .stat-verde .stat-num { color: #27ae60; }
        .stat-rojo .stat-num { color: #e74c3c; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .card h2 { color: #2c3e50; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-size: 13px; }
        th { background: #27ae60; color: white; }
        .badge { padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        .badge-rojo { background: #fdedec; color: #e74c3c; }
        .badge-verde { background: #eafaf1; color: #27ae60; }
        .badge-amarillo { background: #fef9e7; color: #f39c12; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .low-stock { background: #fdedec; }
        .folio { font-family: monospace; font-size: 12px; color: #888; }
        .privacidad { background: #fef9e7; border: 1px solid #f39c12; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px; font-size: 12px; color: #7d6608; display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Farmacia - HealthNexus</h1>
        <div style="display:flex;gap:10px;">
            <a href="/dashboard" class="btn btn-dark">Dashboard</a>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red">Salir</button></form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="privacidad">
            🔒 <strong>Modo Privacidad:</strong> Los datos del paciente están protegidos. Solo visible información de surtido.
        </div>

        <div class="stats">
            <div class="stat-card stat-amarillo">
                <div class="stat-num">{{ $pendientes }}</div>
                <div class="stat-label"> Órdenes Pendientes</div>
            </div>
            <div class="stat-card stat-verde">
                <div class="stat-num">{{ $despachadas }}</div>
                <div class="stat-label"> Órdenes Despachadas</div>
            </div>
            <div class="stat-card stat-rojo">
                <div class="stat-num">{{ $alertas_stock }}</div>
                <div class="stat-label">🚨 Stock Bajo</div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h2> Órdenes de Surtido Pendientes</h2>
                @if($recetas_pendientes->isEmpty())
                    <p style="color:#888; padding:20px;">No hay órdenes pendientes</p>
                @else
                    <table>
                        <tr>
                            <th>Folio</th>
                            <th>Médico</th>
                            <th>Medicamentos</th>
                            <th>Acciones</th>
                        </tr>
                        @foreach($recetas_pendientes as $r)
                            <?php 
                                $items = DB::table('receta_items')->where('receta_id', $r->id)->get();
                                $meds = $items->pluck('medicamento')->implode(', ');
                            ?>
                            <tr>
                                <td><span class="folio">ORD-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $r->doctor_creador }}</td>
                                <td><small>{{ $meds }}</small></td>
                                <td>
                                    <a href="/receta/ver/{{ $r->id }}" class="btn btn-purple" target="_blank"></a>
                                    <form action="/farmacia/despachar/{{ $r->id }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-green"></button></form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="card">
                <h2> Inventario</h2>
                <table>
                    <tr><th>Medicamento</th><th>Stock</th><th>Mínimo</th><th>Ubicación</th><th>Estado</th></tr>
                    @foreach($inventario as $inv)
                    <tr class="{{ $inv->stock_actual <= $inv->stock_minimo ? 'low-stock' : '' }}">
                        <td><strong>{{ $inv->medicamento }}</strong></td>
                        <td>{{ $inv->stock_actual }}</td>
                        <td>{{ $inv->stock_minimo }}</td>
                        <td><small>{{ $inv->ubicacion }}</small></td>
                        <td>
                            @if($inv->stock_actual <= $inv->stock_minimo)
                                <span class="badge badge-rojo">🚨 BAJO</span>
                            @else
                                <span class="badge badge-verde">OK</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
