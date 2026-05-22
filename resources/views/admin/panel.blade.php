<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header-buttons { display: flex; gap: 10px; }
        .btn { padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; font-size: 14px; text-decoration: none; color: white; font-weight: bold; }
        .btn-blue { background: #007bff; }
        .btn-red { background: #e74c3c; }
        .btn-dark { background: #2c3e50; }
        .grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card-full { grid-column: 1 / -1; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; color: white; display: inline-block; margin: 1px; }
        .badge-admin { background: #8e44ad; }
        .badge-superadmin { background: #c0392b; }
        .badge-nivel_a { background: #e74c3c; }
        .badge-nivel_b { background: #f39c12; color: black; }
        .badge-nivel_c { background: #3498db; }
        .badge-enfermeria { background: #1abc9c; }
        .badge-farmacia { background: #27ae60; }
        .badge-gobierno { background: #2c3e50; }
        .badge-rh { background: #9b59b6; }
        .auditoria-card { background: linear-gradient(135deg, #2c3e50, #34495e); color: white; padding: 25px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; text-decoration: none; margin-top: 20px; }
        .auditoria-card:hover { opacity: 0.9; }
        .auditoria-title { font-size: 20px; font-weight: bold; }
        .auditoria-subtitle { font-size: 13px; opacity: 0.8; margin-top: 5px; }
        .auditoria-icon { font-size: 40px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>🛡 Panel de Super Administración</h2>
        <div class="header-buttons">
            <a href="/dashboard" class="btn btn-blue">← Dashboard</a>
            <a href="/auditoria" class="btn btn-dark">🔒 Auditoría</a>
            <a href="/farmacia" class="btn" style="background:#27ae60;"> Farmacia</a>
        </div>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="grid">
        <!-- TABLA DE USUARIOS -->
        <div class="card">
            <h3>👥 Personal Registrado ({{ $users->count() }})</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-{{ strtolower(str_replace(' ', '_', $role->name)) }}">{{ $role->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <!-- FORMULARIO PARA CREAR -->
        <div class="card">
            <h3>➕ Agregar Personal</h3>
            <form action="/admin/create-user" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña (mín. 6)" minlength="6" required>

                <select name="role_id" required>
                    <option value="" disabled selected>Asignar Rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }} - {{ $role->description }}</option>
                    @endforeach
                </select>

                <button type="submit"> Registrar Personal</button>
            </form>
        </div>
    </div>

    <!-- TARJETA DE AUDITORÍA -->
    <a href="/auditoria" class="auditoria-card">
        <div>
            <div class="auditoria-title">🔒 Auditoría Inmutable</div>
            <div class="auditoria-subtitle">Registro completo de logins, navegación e intentos fallidos. Datos protegidos contra eliminación.</div>
        </div>
        <div class="auditoria-icon"></div>
    </a>

</body>
</html>
