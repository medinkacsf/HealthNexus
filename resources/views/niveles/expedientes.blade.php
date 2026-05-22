<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expedientes - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 13px; }
        .btn-dark { background: #2c3e50; }
        .btn-green { background: #27ae60; }
        .btn-blue { background: #2980b9; }
        .container { padding: 20px; max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .card h2 { color: #2c3e50; margin-bottom: 15px; }
        .btn-header { background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; color: white; font-size: 13px; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 13px; }
        th { background: #c0392b; color: white; }
        .folio { font-family: monospace; font-size: 12px; color: #888; background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        .alergia { background: #fdedec; color: #e74c3c; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .empty { text-align: center; padding: 40px; color: #888; }
        .all-badge { background: #27ae60; color: white; padding: 5px 12px; border-radius: 15px; font-size: 11px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📁 Expedientes Clinicos</h1>
        <div style="display:flex;gap:10px;">
            <a href="/expediente/crear" class="btn-header">+ Nuevo</a>
            <a href="/superadmin" class="btn-header">Volver</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <h2> Expedientes ({{ $expedientes->count() }}) <span class="all-badge">TODOS LOS MÉDICOS</span></h2>
            @if($expedientes->isEmpty())
                <div class="empty">
                    <p style="font-size:40px; margin-bottom:10px;">📁</p>
                    <p>No hay expedientes</p>
                </div>
            @else
                <table>
                    <tr>
                        <th>No. Expediente</th>
                        <th>Paciente</th>
                        <th>Genero</th>
                        <th>Alergias</th>
                        <th>Medico</th>
                        <th>Acciones</th>
                    </tr>
                    @foreach($expedientes as $exp)
                    <tr>
                        <td><span class="folio">{{ $exp->num_expediente }}</span></td>
                        <td><strong>{{ $exp->paciente_nombre }}</strong></td>
                        <td>{{ $exp->paciente_genero ?? '-' }}</td>
                        <td>
                            @if($exp->paciente_alergias)
                                <span class="alergia">{{ $exp->paciente_alergias }}</span>
                            @else
                                <span style="color:#27ae60;">Sin alergias</span>
                            @endif
                        </td>
                        <td><small>{{ $exp->doctor_nombre }}</small></td>
                        <td><a href="/expediente/ver/{{ $exp->id }}" class="btn btn-blue">Ver</a></td>
                    </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</body>
</html>
