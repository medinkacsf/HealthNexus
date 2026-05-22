<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HealthNexus - Registro</title>
    <style>
        body { font-family: Arial; background-color: #f0f4f8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        h2 { color: #2c3e50; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #27ae60; color: white; padding: 10px 15px; border: none; border-radius: 5px; width: 100%; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #219150; }
        .error { color: red; font-size: 14px; margin-top: 10px; }
        .link { margin-top: 15px; font-size: 14px; color: #3498db; text-decoration: none; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2> Crear Cuenta</h2>
        
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            
            <input type="text" name="name" placeholder="Nombre completo (Ej: Dr. Perez)" required>
            
            <input type="email" name="email" placeholder="Correo corporativo" required>
            
            <input type="password" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required>
            
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            
            <button type="submit">Registrarse</button>
            
            @if($errors->any())
                <div class="error">{{ $errors->first('email') }}</div>
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
        </form>
        
        <a href="{{ route('login') }}" class="link">¿Ya tienes cuenta? Iniciar Sesión</a>
    </div>
</body>
</html>
