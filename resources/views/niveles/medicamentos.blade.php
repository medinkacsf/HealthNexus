<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuadro Básico - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; height: 100vh; display: flex; flex-direction: column; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; }
        .btn { padding: 7px 14px; border-radius: 5px; border: none; cursor: pointer; font-size: 12px; text-decoration: none; color: white; }
        .btn-azul { background: #2980b9; }
        .content { flex: 1; padding: 20px; overflow-y: auto; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 16px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); text-align: center; }
        .stat-num { font-size: 28px; font-weight: bold; }
        .stat-label { color: #7f8c8d; font-size: 11px; margin-top: 4px; }
        .stat-rojo .stat-num { color: #e74c3c; }
        .stat-amarillo .stat-num { color: #f39c12; }
        .stat-azul .stat-num { color: #2980b9; }
        .stat-verde .stat-num { color: #27ae60; }
        .card { background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 15px; }
        .card-header { background: #f8f9fa; padding: 12px 16px; border-bottom: 2px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { color: #2c3e50; font-size: 14px; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; color: white; }
        .badge-rojo { background: #e74c3c; }
        .badge-amarillo { background: #f39c12; }
        .badge-azul { background: #2980b9; }
        .badge-verde { background: #27ae60; }
        .table-list { width: 100%; border-collapse: collapse; }
        .table-list th { background: #f8f9fa; padding: 10px; text-align: left; font-size: 12px; color: #666; border-bottom: 2px solid #eee; }
        .table-list td { padding: 10px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
        .nivel-badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .nivel-A { background: #f8d7da; color: #721c24; }
        .nivel-B { background: #fff3cd; color: #856404; }
        .nivel-C { background: #d4edda; color: #155724; }
        .controlado-badge { background: #e74c3c; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; }
        .alerta { background: #fdedec; padding: 12px; border-radius: 8px; margin-bottom: 15px; color: #c0392b; font-size: 13px; border-left: 4px solid #e74c3c; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Cuadro Básico - Medicamentos</h1>
        <a href="/nivel-a" class="btn btn-azul">← Volver al Dashboard</a>
    </div>
    <div class="content">
        <div class="stats">
            <div class="stat-card stat-azul">
                <div class="stat-num">{{ $total }}</div>
                <div class="stat-label">Total Medicamentos</div>
            </div>
            <div class="stat-card stat-rojo">
                <div class="stat-num">{{ $total_controlados }}</div>
                <div class="stat-label"> Controlados (Nivel A)</div>
            </div>
            <div class="stat-card stat-amarillo">
                <div class="stat-num">{{ count($nivel_b) }}</div>
                <div class="stat-label">Nivel B (Antibióticos)</div>
            </div>
            <div class="stat-card stat-verde">
                <div class="stat-num">{{ count($nivel_c) }}</div>
                <div class="stat-label">Nivel C (Libre)</div>
            </div>
        </div>

        <div class="alerta">
             <strong>Medicamentos Nivel A</strong> requieren firma obligatoria del Médico Jefe. Incluyen: Morfina, Tramadol, Clonazepam, Alprazolam, Codeína, Ketamina.
        </div>

        <div class="card">
            <div class="card-header">
                <h3> Medicamentos Controlados (Nivel A)</h3>
                <span class="badge badge-rojo">{{ count($nivel_a) }}</span>
            </div>
            <div style="padding:0;overflow-x:auto;">
                <table class="table-list">
                    <tr><th>Código</th><th>Medicamento</th><th>Costo</th><th>Nivel</th><th>Estado</th></tr>
                    @foreach($nivel_a as $m)
                    <tr style="background:#fff5f5;">
                        <td>{{ $m->codigo_barras }}</td>
                        <td><strong>{{ $m->nombre_medicamento }}</strong></td>
                        <td>${{ number_format($m->costo_unitario, 2) }}</td>
                        <td><span class="nivel-badge nivel-A">NIVEL A</span></td>
                        <td><span class="controlado-badge"> CONTROLADO</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3> Antibióticos (Nivel B)</h3>
                <span class="badge badge-amarillo">{{ count($nivel_b) }}</span>
            </div>
            <div style="padding:0;overflow-x:auto;">
                <table class="table-list">
                    <tr><th>Código</th><th>Medicamento</th><th>Costo</th><th>Nivel</th></tr>
                    @foreach($nivel_b as $m)
                    <tr>
                        <td>{{ $m->codigo_barras }}</td>
                        <td>{{ $m->nombre_medicamento }}</td>
                        <td>${{ number_format($m->costo_unitario, 2) }}</td>
                        <td><span class="nivel-badge nivel-B">NIVEL B</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3> Medicamentos Libres (Nivel C)</h3>
                <span class="badge badge-verde">{{ count($nivel_c) }}</span>
            </div>
            <div style="padding:0;overflow-x:auto;">
                <table class="table-list">
                    <tr><th>Código</th><th>Medicamento</th><th>Costo</th><th>Nivel</th></tr>
                    @foreach($nivel_c as $m)
                    <tr>
                        <td>{{ $m->codigo_barras }}</td>
                        <td>{{ $m->nombre_medicamento }}</td>
                        <td>${{ number_format($m->costo_unitario, 2) }}</td>
                        <td><span class="nivel-badge nivel-C">NIVEL C</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
