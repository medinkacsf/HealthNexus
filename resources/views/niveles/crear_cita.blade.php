<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Cita - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; height: 100vh; display: flex; flex-direction: column; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; }
        .btn { padding: 7px 14px; border-radius: 5px; border: none; cursor: pointer; font-size: 12px; text-decoration: none; color: white; }
        .btn-azul { background: #2980b9; }
        .btn-verde { background: #27ae60; }
        .content { flex: 1; padding: 20px; overflow-y: auto; display: flex; justify-content: center; }
        .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: 500px; }
        .form-card h2 { color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px 14px; border: 2px solid #ddd; border-radius: 8px; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group select:focus { border-color: #c0392b; }
        .info-box { background: #eafaf1; padding: 12px; border-radius: 8px; font-size: 12px; color: #155724; margin-bottom: 20px; }
        .precios { background: #fef9e7; padding: 12px; border-radius: 8px; font-size: 12px; color: #7d6608; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Nueva Cita</h1>
        <a href="/citas/agenda" class="btn btn-azul">← Volver a Agenda</a>
    </div>
    <div class="content">
        <div class="form-card">
            <h2> Agendar Nueva Cita</h2>
            <div class="info-box">
                 El paciente recibirá confirmación por WhatsApp al número que registres
            </div>
            <div class="precios">
                <strong> Precios de referencia:</strong><br>
                Consulta General: $800 | Cardiología: $1,200 | Pediatría: $600 | Traumatología: $1,000
            </div>
            <form action="/citas/guardar" method="POST">
                @csrf
                <div class="form-group">
                    <label> Nombre del Paciente *</label>
                    <input type="text" name="paciente_nombre" required placeholder="Nombre completo">
                </div>
                <div class="form-group">
                    <label> Teléfono (WhatsApp) *</label>
                    <input type="text" name="telefono" required placeholder="Ej: 527201234567" value="{{ request('telefono', '') }}">
                </div>
                <div class="form-group">
                    <label> Fecha *</label>
                    <input type="date" name="fecha" required value="{{ request('fecha', date('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label> Horario *</label>
                    <select name="horario" required>
                        <option value="">Seleccionar horario</option>
                        @php
                            $horarios = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'];
                            foreach($horarios as $h) {
                                $sel = (request('horario') == $h) ? 'selected' : '';
                                echo "<option value='$h' $sel>$h</option>";
                            }
                        @endphp
                    </select>
                </div>
                <div class="form-group">
                    <label> Motivo de la Consulta *</label>
                    <select name="motivo" required>
                        <option value="">Seleccionar</option>
                        <option value="Consulta general">Consulta general ($800)</option>
                        <option value="Cardiologia">Cardiología ($1,200)</option>
                        <option value="Traumatologia">Traumatología ($1,000)</option>
                        <option value="Pediatria">Pediatría ($600)</option>
                        <option value="Control">Control de seguimiento ($500)</option>
                        <option value="Urgencias">Urgencias ($1,500)</option>
                        <option value="Laboratorio">Toma de laboratorio ($350)</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button type="submit" class="btn btn-verde" style="flex:1;padding:12px;"> Confirmar Cita</button>
                    <a href="/citas/agenda" class="btn btn-azul" style="padding:12px;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
