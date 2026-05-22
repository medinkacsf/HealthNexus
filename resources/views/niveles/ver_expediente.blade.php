<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 13px; }
        .btn-dark { background: #2c3e50; }
        .btn-green { background: #27ae60; }
        .container { padding: 20px; max-width: 1200px; margin: 0 auto; }
        .grid { display: grid; grid-template-columns: 300px 1fr; gap: 20px; }
        .sidebar { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); height: fit-content; }
        .sidebar h3 { color: #2c3e50; margin-bottom: 15px; font-size: 15px; }
        .dato { margin-bottom: 12px; }
        .dato-label { font-size: 11px; color: #888; text-transform: uppercase; }
        .dato-valor { font-size: 14px; font-weight: bold; }
        .alergia-box { background: #fdedec; color: #e74c3c; padding: 8px 12px; border-radius: 8px; font-size: 13px; font-weight: bold; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .card h2 { color: #2c3e50; margin-bottom: 15px; }
        .nota { background: #f8f9fa; border-left: 4px solid #c0392b; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 15px; }
        .nota-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .nota-doctor { font-weight: bold; font-size: 13px; }
        .nota-fecha { font-size: 12px; color: #888; }
        .nota-tipo { display: inline-block; background: #c0392b; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-bottom: 8px; }
        .vitales { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 10px 0; }
        .vital { background: white; padding: 8px; border-radius: 5px; text-align: center; border: 1px solid #eee; }
        .vital-val { font-size: 18px; font-weight: bold; color: #c0392b; }
        .vital-label { font-size: 10px; color: #888; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 3px; font-size: 12px; color: #555; }
        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }
        textarea { height: 60px; resize: vertical; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .btn-submit { background: #c0392b; color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; }
        .btn-print { background: #8e44ad; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h1> Expediente {{ $expediente->num_expediente }}</h1>
        <div class="no-print" style="display:flex;gap:10px;">
            <button class="btn btn-print" onclick="window.print()"> Imprimir</button>
            <a href="/expedientes" class="btn btn-dark">← Volver</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <div class="sidebar">
                <h3> Datos del Paciente</h3>
                <div class="dato">
                    <div class="dato-label">Nombre</div>
                    <div class="dato-valor">{{ $expediente->paciente_nombre }}</div>
                </div>
                <div class="dato">
                    <div class="dato-label">CURP</div>
                    <div class="dato-valor">{{ $expediente->paciente_curp ?? '-' }}</div>
                </div>
                <div class="dato">
                    <div class="dato-label">Fecha de Nacimiento</div>
                    <div class="dato-valor">{{ $expediente->paciente_fecha_nacimiento ?? '-' }}</div>
                </div>
                <div class="dato">
                    <div class="dato-label">Género</div>
                    <div class="dato-valor">{{ $expediente->paciente_genero ?? '-' }}</div>
                </div>
                @if($expediente->paciente_alergias)
                <div class="alergia-box">
                     ALERGIAS: {{ $expediente->paciente_alergias }}
                </div>
                @endif
                <div class="dato" style="margin-top:15px;">
                    <div class="dato-label">Antecedentes</div>
                    <div class="dato-valor" style="font-weight:normal;font-size:13px;">{{ $expediente->paciente_antecedentes ?? 'Sin antecedentes registrados' }}</div>
                </div>
                <div class="dato" style="margin-top:15px;">
                    <div class="dato-label">Médico Responsable</div>
                    <div class="dato-valor">{{ $expediente->doctor_nombre }}</div>
                </div>
            </div>

            <div>
                <div class="card">
                    <h2> Notas Clínicas ({{ $notas->count() }})</h2>
                    @if($notas->isEmpty())
                        <p style="color:#888;">No hay notas aún</p>
                    @else
                        @foreach($notas as $nota)
                            <?php $vitales = json_decode($nota->signos_vitales, true); ?>
                            <div class="nota">
                                <div class="nota-header">
                                    <span class="nota-tipo">{{ strtoupper($nota->tipo_nota) }}</span>
                                    <span class="nota-fecha">{{ date('d/m/Y H:i', strtotime($nota->created_at)) }}</span>
                                </div>
                                <div class="nota-doctor">Dr. {{ $nota->doctor_nombre }}</div>
                                @if($vitales)
                                <div class="vitales">
                                    <div class="vital"><div class="vital-val">{{ $vitales['ta'] ?? '-' }}</div><div class="vital-label">TA</div></div>
                                    <div class="vital"><div class="vital-val">{{ $vitales['fc'] ?? '-' }}</div><div class="vital-label">FC</div></div>
                                    <div class="vital"><div class="vital-val">{{ $vitales['temp'] ?? '-' }}</div><div class="vital-label">TEMP</div></div>
                                    <div class="vital"><div class="vital-val">{{ $vitales['spo2'] ?? '-' }}</div><div class="vital-label">SpO2</div></div>
                                </div>
                                @endif
                                <p style="font-size:13px;margin:8px 0;"><strong>Nota:</strong> {{ $nota->nota_clinica }}</p>
                                <p style="font-size:13px;margin:5px 0;"><strong>Diagnóstico:</strong> {{ $nota->diagnostico }}</p>
                                <p style="font-size:13px;margin:5px 0;"><strong>Tratamiento:</strong> {{ $nota->tratamiento }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="card no-print">
                    <h2> Agregar Nota Clínica</h2>
                    <form action="/expediente/nota/{{ $expediente->id }}" method="POST">
                        @csrf
                        <div class="form-grid">
                            <div>
                                <label>Tipo de Nota</label>
                                <select name="tipo_nota" required>
                                    <option value="consulta">Consulta</option>
                                    <option value="urgencia">Urgencia</option>
                                    <option value="seguimiento">Seguimiento</option>
                                    <option value="interconsulta">Interconsulta</option>
                                </select>
                            </div>
                            <div></div>
                            <div>
                                <label>TA (mmHg)</label>
                                <input type="text" name="ta" placeholder="120/80">
                            </div>
                            <div>
                                <label>FC (lpm)</label>
                                <input type="number" name="fc" placeholder="72">
                            </div>
                            <div>
                                <label>Temp (°C)</label>
                                <input type="text" name="temp" placeholder="36.5">
                            </div>
                            <div>
                                <label>SpO2 (%)</label>
                                <input type="number" name="spo2" placeholder="98">
                            </div>
                        </div>
                        <label>Nota Clínica *</label>
                        <textarea name="nota_clinica" required placeholder="Descripción del padecimiento actual..."></textarea>
                        <label>Diagnóstico *</label>
                        <textarea name="diagnostico" required placeholder="Diagnóstico..."></textarea>
                        <label>Tratamiento *</label>
                        <textarea name="tratamiento" required placeholder="Indicaciones terapéuticas..."></textarea>
                        <button type="submit" class="btn-submit"> Guardar Nota</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
