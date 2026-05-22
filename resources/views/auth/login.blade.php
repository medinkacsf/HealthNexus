<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HealthNexus - Login</title>
    <style>
        body { font-family: Arial; background-color: #f0f4f8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        h2 { color: #2c3e50; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #3498db; color: white; padding: 10px 15px; border: none; border-radius: 5px; width: 100%; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #2980b9; }
        .error { color: red; font-size: 14px; margin-top: 10px; }
        h4 { color: #7f8c8d; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2> HealthNexus</h2>
        <h4>Sistema de Gestión Hospitalaria</h4>
        
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
            
            @if($errors->any())
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </form>
        
        <p style="margin-top: 20px; font-size: 12px; color: #888;">Acceso restringido a personal autorizado.</p>
    </div>
</body>
</html>
