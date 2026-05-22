<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Médica - HealthNexus</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 20px 30px; border-radius: 10px 10px 0 0; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header h1 { margin: 0; font-size: 24px; }
        .user-info { font-size: 14px; opacity: 0.9; }
        
        .nav-bar { background: white; padding: 10px 30px; border-bottom: 1px solid #ddd; display: flex; gap: 10px; align-items: center; }
        .btn { padding: 8px 16px; border-radius: 4px; text-decoration: none; color: white; font-size: 14px; border: none; cursor: pointer; display: inline-block; }
        .btn-primary { background: #27ae60; }
        .btn-pharma { background: #8e44ad; }
        
        .card { background: white; padding: 20px; border-radius: 0 0 10px 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        h2 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 0; font-size: 18px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #555; font-weight: 600; }
        
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .bg-pendiente { background: #f39c12; color: white; }
        .bg-confirmada { background: #27ae60; color: white; }
        .bg-atendida { background: #3498db; color: white; }
        .bg-cancelada { background: #c0392b; color: white; }
        
        .btn-sm { padding: 5px 10px; font-size: 12px; text-decoration: none; color: white; border-radius: 3px; margin-right: 5px; display: inline-block; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1>Agenda de Citas - HealthNexus</h1>
        </div>
        <div class="user-info">
            <strong>{{ $user->name }}</strong>
            <br><a href="/home" style="color:white; text-decoration:none;">Volver al Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline-block; margin-left: 15px;">
                        @csrf
                        <button type="submit" class="btn-sm" style="background:#c0392b; color: white; border:none; cursor:pointer; padding: 8px 15px; border-radius:4px;">Cerrar Sesión</button>
                    </form>
        </div>
    </div>

    <div class="nav-bar">
        <a href="/citas/nueva" class="btn btn-primary">+ Nueva Cita</a>
        @if(session('success'))
            <span style="color: green; margin-left: auto; font-weight: bold;">{{ session('success') }}</span>
        @endif
    </div>

    <div class="card">
        <h2> Citas de Hoy</h2>
        @php $hoy = date('Y-m-d'); @endphp
        @if(count($citas) > 0)
        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $c)
                @php $fecha_cita = substr($c->created_at, 0, 10); @endphp
                @if($fecha_cita == $hoy)
                <tr>
                    <td>{{ $c->horario ?? substr($c->created_at, 11, 5) }}</td>
                    <td><strong>{{ $c->paciente_nombre }}</strong></td>
                    <td>{{ $c->motivo }}</td>
                    <td><span class="badge bg-{{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
                    <td>
                        @if($c->estado == 'pendiente')
                            <a href="/citas/cambiar/{{ $c->id }}/confirmada" class="btn-sm" style="background:#27ae60;"></a>
                        @elseif($c->estado == 'confirmada')
                            <a href="/citas/atender/{{ $c->id }}" class="btn-sm" style="background:#2980b9;"> Atender</a>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color: #777;">No hay citas para hoy.</p>
        @endif

        <h2> Todas las Citas</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Teléfono</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $c)
                <tr>
                    <td>{{ $c->fecha_cita ?? substr($c->created_at, 0, 10) }}</td>
                    <td>{{ $c->horario ?? substr($c->created_at, 11, 5) }}</td>
                    <td><strong>{{ $c->paciente_nombre }}</strong></td>
                    <td>{{ $c->telefono }}</td>
                    <td>{{ $c->motivo }}</td>
                    <td><span class="badge bg-{{ $c->estado }}">{{ ucfirst($c->estado) }}</span></td>
                    <td>
                        @if($c->estado == 'pendiente')
                            <a href="/citas/cambiar/{{ $c->id }}/confirmada" class="btn-sm" style="background:#27ae60;">Confirmar</a>
                            <a href="/citas/cambiar/{{ $c->id }}/cancelada" class="btn-sm" style="background:#e74c3c;">Cancelar</a>
                        @elseif($c->estado == 'confirmada')
                            <a href="/citas/atender/{{ $c->id }}" class="btn-sm" style="background:#2980b9;"> Atender</a>
                        @elseif($c->estado == 'atendida')
                            <a href="/citas/enviar-farmacia/{{ $c->id }}" class="btn-sm" style="background:#8e44ad;"> Enviar a Farmacia</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
