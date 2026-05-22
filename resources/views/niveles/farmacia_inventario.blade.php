<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Farmacia - HealthNexus</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f9; padding: 20px; margin: 0; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #ecf0f1; color: #2c3e50; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; font-size: 14px; border: none; cursor: pointer; display: inline-block;}
        .btn-back { background: #7f8c8d; }
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; color: white; font-size: 12px; }
        .bg-ok { background: #27ae60; }
        .bg-low { background: #e67e22; }
        .bg-empty { background: #c0392b; }
    </style>
</head>
<body>

<div class="header">
    <h1> Inventario Farmacéutico</h1>
    <a href="/farmacia" class="btn btn-back">Volver a Recetas</a>
</div>

<div class="card">
    <h2>Existencia en Almacén ({{ count($medicamentos) }} medicamentos)</h2>
    <table>
        <thead>
            <tr>
                <th>Código Barras</th>
                <th>Medicamento</th>
                <th>Nivel</th>
                <th>Stock Actual</th>
                <th>Costo Unit.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicamentos as $m)
            <tr>
                <td><small>{{ $m->codigo_barras }}</small></td>
                <td><strong>{{ $m->nombre_medicamento }}</strong></td>
                <td>{{ $m->requiere_nivel_minimo }}</td>
                <td>
                    @if($m->existencia == 0)
                        <span class="badge bg-empty">Agotado (0)</span>
                    @elseif($m->existencia < 5)
                        <span class="badge bg-low">Bajo ({{ $m->existencia }})</span>
                    @else
                        <span class="badge bg-ok">{{ $m->existencia }}</span>
                    @endif
                </td>
                <td>${{ number_format($m->costo_unitario, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
