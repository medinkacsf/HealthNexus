<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Expediente - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 13px; }
        .btn-dark { background: #2c3e50; }
        .container { padding: 20px; max-width: 800px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .card h2 { color: #2c3e50; margin-bottom: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 3px; font-size: 12px; color: #555; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; margin-bottom: 15px; }
        textarea { height: 70px; }
        .btn-submit { background: #c0392b; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📁 Nuevo Expediente Clínico</h1>
        <a href="/expedientes" class="btn btn-dark">← Volver</a>
    </div>

    <div class="container">
        <form action="/expediente/guardar" method="POST">
            @csrf
            <div class="card">
                <h2>👤 Datos del Paciente</h2>
                <div class="form-grid">
                    <div>
                        <label>Nombre Completo *</label>
                        <input type="text" name="paciente_nombre" required placeholder="Nombre completo">
                    </div>
                    <div>
                        <label>No. Expediente *</label>
                        <input type="text" name="num_expediente" value="{{ $num_exp }}" required readonly style="background:#eee;">
                    </div>
                    <div>
                        <label>CURP</label>
                        <input type="text" name="paciente_curp" placeholder="CURP del paciente">
                    </div>
                    <div>
                        <label>Género</label>
                        <select name="paciente_genero">
                            <option value="">Seleccionar...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div>
                        <label>Fecha de Nacimiento</label>
                        <input type="date" name="paciente_fecha_nacimiento">
                    </div>
                    <div>
                        <label>Alergias</label>
                        <input type="text" name="paciente_alergias" placeholder="Ej: Penicilina, Aspirina">
                    </div>
                </div>
                <label>Antecedentes Patológicos</label>
                <textarea name="paciente_antecedentes" placeholder="Diabetes, Hipertensión, Cirugías previas..."></textarea>

                <div style="text-align:center; margin-top:20px;">
                    <button type="submit" class="btn-submit"> Crear Expediente</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
