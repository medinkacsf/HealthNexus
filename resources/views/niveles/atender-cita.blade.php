<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atender Cita - HealthNexus</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { color: #2c3e50; margin: 0; font-size: 24px; }
        .btn-back { text-decoration: none; background: #95a5a6; color: white; padding: 8px 15px; border-radius: 5px; font-size: 14px; }
        .section-title { color: #2980b9; border-left: 4px solid #2980b9; padding-left: 10px; margin: 25px 0 15px 0; font-size: 18px; font-weight: bold; }
        
        .patient-card { background: #e8f6f3; padding: 15px; border-radius: 8px; border: 1px solid #d1f2eb; display: flex; gap: 20px; flex-wrap: wrap; }
        .p-item { flex: 1; min-width: 200px; }
        .p-label { font-size: 12px; color: #7f8c8d; text-transform: uppercase; font-weight: bold; }
        .p-value { font-size: 16px; color: #2c3e50; font-weight: 600; }

        .grid-vitals { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #34495e; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        .form-control:focus { border-color: #2980b9; outline: none; }
        
        textarea.form-control { min-height: 80px; resize: vertical; }
        
        .btn-submit { background: #27ae60; color: white; border: none; padding: 12px 25px; font-size: 16px; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 20px; }
        .btn-submit:hover { background: #219150; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1> Consulta Médica</h1>
        <a href="/citas/agenda" class="btn-back">← Volver a Agenda</a>
    </div>

    <form action="/citas/atender/{{ $cita->id }}" method="POST">
        @csrf
        
        <!-- Info Paciente -->
        <div class="patient-card">
            <div class="p-item">
                <div class="p-label">Paciente</div>
                <div class="p-value">{{ $cita->paciente_nombre }}</div>
                <input type="hidden" name="paciente_nombre" value="{{ $cita->paciente_nombre }}">
            </div>
            <div class="p-item">
                <div class="p-label">Motivo Cita</div>
                <div class="p-value">{{ $cita->motivo }}</div>
                <input type="hidden" name="motivo_consulta" value="{{ $cita->motivo }}">
            </div>
            <div class="p-item">
                <div class="p-label">Teléfono</div>
                <div class="p-value">{{ $cita->telefono }}</div>
            </div>
            <div class="p-item">
                <div class="p-label">Fecha</div>
                <div class="p-value">{{ $cita->fecha_cita ?? 'Hoy' }} - {{ $cita->horario }}</div>
            </div>
        </div>

        <!-- Signos Vitales -->
        <div class="section-title">Signos Vitales</div>
        <div class="grid-vitals">
            <div class="form-group">
                <label>P. Arterial</label>
                <input type="text" name="presion_arterial" class="form-control" placeholder="120/80">
            </div>
            <div class="form-group">
                <label>F.C. (lpm)</label>
                <input type="number" name="frecuencia_cardiaca" class="form-control" placeholder="72">
            </div>
            <div class="form-group">
                <label>F.R. (rpm)</label>
                <input type="number" name="frecuencia_respiratoria" class="form-control" placeholder="16">
            </div>
            <div class="form-group">
                <label>Temp (°C)</label>
                <input type="number" step="0.1" name="temperatura" class="form-control" placeholder="36.5">
            </div>
            <div class="form-group">
                <label>Peso (kg)</label>
                <input type="number" step="0.1" name="peso" class="form-control" placeholder="70.5">
            </div>
            <div class="form-group">
                <label>Talla (m)</label>
                <input type="number" step="0.01" name="talla" class="form-control" placeholder="1.70">
            </div>
            <div class="form-group">
                <label>SpO2 (%)</label>
                <input type="number" name="spo2" class="form-control" placeholder="98">
            </div>
        </div>

        <!-- Exploración y Diagnóstico -->
        <div class="section-title">Exploración y Diagnóstico</div>
        <div class="form-group">
            <label>Exploración Física</label>
            <textarea name="exploracion_fisica" class="form-control" placeholder="Datos relevantes de la exploración..."></textarea>
        </div>
        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 3;">
                <label>Diagnóstico *</label>
                <textarea name="diagnostico" class="form-control" required placeholder="Diagnóstico principal..."></textarea>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>CIE-10</label>
                <input type="text" name="cie10" class="form-control" placeholder="Ej: J06.9">
            </div>
        </div>

        <!-- Tratamiento -->
        <div class="section-title">Tratamiento e Indicaciones</div>
        <div class="form-group">
            <label>Receta Médica</label>
            <textarea name="receta_medica" class="form-control" placeholder="Medicamento, dosis y presentación...&#10;Ej: Ibuprofeno 600mg cada 8 horas"></textarea>
        </div>
        <div class="form-group">
            <label>Indicaciones Generales</label>
            <textarea name="indicaciones" class="form-control" placeholder="Reposo, dieta, cuidados..."></textarea>
        </div>

        <!-- Notas -->
        <div class="form-group">
            <label>Notas Médicas (Interno)</label>
            <textarea name="notas_medicas" class="form-control" placeholder="Observaciones privadas..."></textarea>
        </div>

        <button type="submit" class="btn-submit">💾 Guardar Consulta y Finalizar</button>
    </form>
</div>

</body>
</html>
