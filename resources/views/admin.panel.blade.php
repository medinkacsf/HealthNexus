<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Admin - HealthNexus</title>
    <style>
        body { font-family: Arial; background-color: #f0f4f8; margin: 0; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; }
        h1, h2 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        .form-group { display: flex; gap: 10px; margin-top: 20px; align-items: center; }
        input, select { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; color: white; }
        .btn-create { background-color: #27ae60; }
        .btn-logout { background-color: #e74c3c; text-decoration: none; }
        .success { color: #27ae60; font-weight: bold; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>👑 Panel de Administración</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-logout">Volver al Dashboard</a>
    </div>

    <div class="card">
        <h2>Personal del Hospital</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol Asignado</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><strong>{{ $user->role ? $user->role->name : 'Sin rol' }}</strong></td>
            </tr>
            @endforeach
        </table>

        <hr style="margin-top: 30px;">

        <!-- FORMULARIO SECRETO PARA CREAR USUARIOS -->
        <h2>Dar de Alta Nuevo Personal</h2>
        
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.store.user') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="Nombre del Doctor/Personal" required>
                <input type="email" name="email" placeholder="Correo del hospital" required>
                <input type="password" name="password" placeholder="Contraseña temporal" required>
                
                <!-- MENÚ DESPLEGABLE PARA ELEGIR EL ROL -->
                <select name="role_id" required>
                    <option value="">-- Seleccionar Rol --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-create">Crear Usuario</button>
            </div>
        </form>
    </div>
</body>
</html>
