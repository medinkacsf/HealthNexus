<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atender Cita - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #333; }
        
        .header { background: linear-gradient(135deg, #1a5276, #2980b9); color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 22px; }
        .header a { color: white; text-decoration: none; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 6px; font-size: 14px; }
        .header a:hover { background: rgba(255,255,255,0.3); }
        
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        
        .paciente-info { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .paciente-info h2 { color: #1a5276; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #2980b9; padding-bottom: 8px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; }
        .info-item { padding: 8px; background: #f8f9fa; border-radius: 6px; }
        .info-item label { font-weight: bold; color: #555; font-size: 12px; display: block; }
        .info-item span { font-size: 15px; color: #222; }
        
        .form-section { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .form-section h2 { color: #1a5276; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #2980b9; padding-bottom: 8px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #444; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #2980b9; box-shadow: 0 0 0 3px rgba(41,128,185,0.1); }
        
        .signos-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; }
        .signo-item label { font-size: 12px; color: #666; }
        .signo-item input { padding: 8px; font-size: 14px; }
        
        .receta-container { border: 2px dashed #2980b9; border-radius: 8px; padding: 15px; background: #f0f8ff; }
        .medicamento-row { display: grid; grid-template-columns: 3fr 1fr 1fr 2fr auto; gap: 8px; margin-bottom: 8px; align-items: end; }
        .medicamento-row input, .medicamento-row select { padding: 8px; font-size: 13px; }
        .btn-add-med { background: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 13px; margin-top: 5px; }
        .btn-add-med:hover { background: #219a52; }
        .btn-remove-med { background: #e74c3c; color: white; border: none; padding: 8px 10px; border-radius: 6px; cursor: pointer; font-size: 13px; }
        .btn-remove-med:hover { background: #c0392b; }
        
        .btn-container { display: flex; gap: 15px; margin-top: 20px; justify-content: center; }
        .btn-primary { background: linear-gradient(135deg, #1a5276, #2980b9); color: white; border: none; padding: 14px 35px; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-secondary { background: #7f8c8d; color: white; border: none; padding: 14px 35px; border-radius: 8px; cursor: pointer; font-size: 16px; }
        .btn-secondary:hover { background: #6c7a7b; }
        .btn-print { background: #8e44ad; color: white; border: none; padding: 14px 35px; border-radius: 8px; cursor: pointer; font-size: 16px; }
        .btn-print:hover { background: #7d3c98; }
        
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        /* Estilos para impresión de receta */
        @media print {
            body { background: white; }
            .header, .btn-container, .no-print, .btn-add-med, .btn-remove-med { display: none !important; }
            .container { max-width: 100%; margin: 0; padding: 0; }
            .form-section { box-shadow: none; border: none; page-break-inside: avoid; }
            .receta-container { border: 2px solid #000; background: white; }
        }
        
        .receta-print { display: none; }
        @media print {
            .receta-print { display: block; }
            .receta-print h2 { text-align: center; font-size: 18px; margin-bottom: 10px; }
            .receta-print .datos-receta { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; font-size: 12px; margin-bottom: 10px; }
            .receta-print .datos-receta p { margin: 2px 0; }
            .receta-print table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            .receta-print th, .receta-print td { border: 1px solid #333; padding: 6px; font-size: 12px; text-align: left; }
            .receta-print th { background: #eee; }
            .receta-print .firma { margin-top: 60px; text-align: center; }
            .receta-print .firma-linea { border-top: 1px solid #333; width: 250px; margin: 0 auto; padding-top: 5px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1> Atender Cita Médica</h1>
        <a href="/citas/agenda">← Volver a Agenda</a>
    </div>
    
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        
        <!-- Información del Paciente -->
        <div class="paciente-info">
            <h2>👤 Datos del Paciente</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nombre</label>
                    <span>{{ $cita->paciente_nombre }}</span>
                </div>
                <div class="info-item">
                    <label>Teléfono</label>
                    <span>{{ $cita->telefono }}</span>
                </div>
                <div class="info-item">
                    <label>Fecha de Cita</label>
                    <span>{{ $cita->fecha_cita ?? substr($cita->created_at, 0, 10) }}</span>
                </div>
                <div class="info-item">
                    <label>Horario</label>
                    <span>{{ $cita->horario ?? 'N/A' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <label>Motivo de Consulta</label>
                    <span style="color: #c0392b; font-weight: bold;">{{ $cita->motivo }}</span>
                </div>
            </div>
        </div>
        
        <!-- Formulario de Atención -->
        <form id="formAtencion" method="POST" action="/citas/atender/{{ $cita->id }}">
            @csrf
            <input type="hidden" name="cita_id" value="{{ $cita->id }}">
            
            <!-- Signos Vitales -->
            <div class="form-section">
                <h2>💓 Signos Vitales</h2>
                <div class="signos-grid">
                    <div class="form-group signo-item">
                        <label>TA (mmHg)</label>
                        <input type="text" name="ta" placeholder="120/80" pattern="\d{2,3}/\d{2,3}">
                    </div>
                    <div class="form-group signo-item">
                        <label>FC (lpm)</label>
                        <input type="number" name="fc" placeholder="80" min="20" max="220">
                    </div>
                    <div class="form-group signo-item">
                        <label>FR (rpm)</label>
                        <input type="number" name="fr" placeholder="18" min="8" max="60">
                    </div>
                    <div class="form-group signo-item">
                        <label>Temp (°C)</label>
                        <input type="number" name="temp" placeholder="36.5" step="0.1" min="34" max="42">
                    </div>
                    <div class="form-group signo-item">
                        <label>Peso (kg)</label>
                        <input type="number" name="peso" placeholder="70" step="0.1" min="1" max="300">
                    </div>
                    <div class="form-group signo-item">
                        <label>Talla (cm)</label>
                        <input type="number" name="talla" placeholder="170" min="30" max="250">
                    </div>
                    <div class="form-group signo-item">
                        <label>SpO2 (%)</label>
                        <input type="number" name="spo2" placeholder="98" min="50" max="100">
                    </div>
                    <div class="form-group signo-item">
                        <label>Glucemia (mg/dl)</label>
                        <input type="number" name="glucemia" placeholder="90" min="20" max="600">
                    </div>
                </div>
            </div>
            
            <!-- Diagnóstico -->
            <div class="form-section">
                <h2>🔍 Diagnóstico</h2>
                <div class="form-group">
                    <label>Diagnóstico / Impresión Clínica</label>
                    <textarea name="diagnostico" required placeholder="Describa el diagnóstico del paciente..."></textarea>
                </div>
                <div class="form-group">
                    <label>CIE-10 (opcional)</label>
                    <input type="text" name="cie10" placeholder="Ej: J06.9, K30, M54.5">
                </div>
            </div>
            
            <!-- Receta Médica -->
            <div class="form-section">
                <h2> Receta Médica</h2>
                <div class="receta-container" id="recetaContainer">
                    <div class="medicamento-row" style="margin-bottom: 10px; font-weight: bold; font-size: 12px; color: #666;">
                        <span>Medicamento</span>
                        <span>Cantidad</span>
                        <span>Días</span>
                        <span>Posología</span>
                        <span></span>
                    </div>
                    <div id="medicamentosList">
                        <div class="medicamento-row medicamento-item">
                            <select name="medicamentos[0][nombre]" required onchange="updateControlado(this)">
                                <option value="">Seleccionar...</option>
                                @foreach($medicamentos as $med)
                                    <option value="{{ $med->nombre_medicamento }}" data-controlado="{{ $med->es_controlado }}" data-nivel="{{ $med->requiere_nivel_minimo }}" data-costo="{{ $med->costo_unitario }}">
                                        {{ $med->nombre_medicamento }} - ${{ number_format($med->costo_unitario, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="medicamentos[0][cantidad]" placeholder="Cant" min="1" value="1">
                            <input type="number" name="medicamentos[0][dias]" placeholder="Días" min="1" value="7">
                            <input type="text" name="medicamentos[0][posologia]" placeholder="Ej: 1 cada 8 hrs" required>
                            <button type="button" class="btn-remove-med" onclick="removeMed(this)">✕</button>
                        </div>
                    </div>
                    <button type="button" class="btn-add-med" onclick="addMedicamento()">+ Agregar Medicamento</button>
                </div>
            </div>
            
            <!-- Indicaciones -->
            <div class="form-section">
                <h2> Indicaciones Generales</h2>
                <div class="form-group">
                    <label>Indicaciones para el paciente</label>
                    <textarea name="indicaciones" placeholder="Dieta, reposo, ejercicios, cuidados especiales..."></textarea>
                </div>
                <div class="form-group">
                    <label>Estudios / Laboratorios solicitados</label>
                    <textarea name="estudios" placeholder="Ej: BHG, QS, EGO, Rayos X..."></textarea>
                </div>
                <div class="form-group">
                    <label>Próxima cita</label>
                    <input type="date" name="proxima_cita">
                </div>
            </div>
            
            <!-- Observaciones -->
            <div class="form-section">
                <h2>📝 Observaciones</h2>
                <div class="form-group">
                    <label>Notas adicionales</label>
                    <textarea name="observaciones" placeholder="Observaciones adicionales del médico..."></textarea>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="btn-container no-print">
                <button type="submit" class="btn-primary"> Guardar y Atender Cita</button>
                <button type="button" class="btn-print" onclick="imprimirReceta()"> Imprimir Receta</button>
                <a href="/citas/agenda" class="btn-secondary">Cancelar</a>
            </div>
        </form>
        
        <!-- Versión para impresión -->
        <div class="receta-print" id="recetaPrint">
            <h2>HOSPITAL GENERAL - RECETA MÉDICA</h2>
            <div class="datos-receta">
                <p><strong>Fecha:</strong> <span id="print-fecha"></span></p>
                <p><strong>Hora:</strong> <span id="print-hora"></span></p>
                <p><strong>Paciente:</strong> {{ $cita->paciente_nombre }}</p>
                <p><strong>Teléfono:</strong> {{ $cita->telefono }}</p>
                <p><strong>Diagnóstico:</strong> <span id="print-diagnostico"></span></p>
                <p><strong>CIE-10:</strong> <span id="print-cie10"></span></p>
            </div>
            <table>
                <thead>
                    <tr><th>Medicamento</th><th>Cant.</th><th>Días</th><th>Posología</th></tr>
                </thead>
                <tbody id="print-medicamentos"></tbody>
            </table>
            <p><strong>Indicaciones:</strong> <span id="print-indicaciones"></span></p>
            <p><strong>Estudios:</strong> <span id="print-estudios"></span></p>
            <p><strong>Próxima cita:</strong> <span id="print-proxima"></span></p>
            <div class="firma">
                <div class="firma-linea">
                    Dr. {{ Auth::user()->name ?? 'Médico Tratante' }}<br>
                    Cédula Profesional
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let medIndex = 1;
        
        function addMedicamento() {
            const container = document.getElementById('medicamentosList');
            const row = document.createElement('div');
            row.className = 'medicamento-row medicamento-item';
            row.innerHTML = `
                <select name="medicamentos[${medIndex}][nombre]" required onchange="updateControlado(this)">
                    <option value="">Seleccionar...</option>
                    @foreach($medicamentos as $med)
                        <option value="{{ $med->nombre_medicamento }}" data-controlado="{{ $med->es_controlado }}" data-nivel="{{ $med->requiere_nivel_minimo }}" data-costo="{{ $med->costo_unitario }}">
                            {{ $med->nombre_medicamento }} - ${{ number_format($med->costo_unitario, 2) }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="medicamentos[${medIndex}][cantidad]" placeholder="Cant" min="1" value="1">
                <input type="number" name="medicamentos[${medIndex}][dias]" placeholder="Días" min="1" value="7">
                <input type="text" name="medicamentos[${medIndex}][posologia]" placeholder="Ej: 1 cada 8 hrs" required>
                <button type="button" class="btn-remove-med" onclick="removeMed(this)">✕</button>
            `;
            container.appendChild(row);
            medIndex++;
        }
        
        function removeMed(btn) {
            const items = document.querySelectorAll('.medicamento-item');
            if (items.length > 1) {
                btn.closest('.medicamento-item').remove();
            }
        }
        
        function updateControlado(select) {
            const option = select.options[select.selectedIndex];
            const esControlado = option.dataset.controlado === '1';
            const nivel = option.dataset.nivel;
            if (esControlado) {
                if (!confirm('⚠ Este es un MEDICAMENTO CONTROLADO (Nivel ' + nivel + '). ¿Está autorizado para recetarlo?')) {
                    select.selectedIndex = 0;
                }
            }
        }
        
        function imprimirReceta() {
            // Llenar datos de impresión
            const now = new Date();
            document.getElementById('print-fecha').textContent = now.toLocaleDateString('es-MX');
            document.getElementById('print-hora').textContent = now.toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit'});
            document.getElementById('print-diagnostico').textContent = document.querySelector('[name="diagnostico"]').value;
            document.getElementById('print-cie10').textContent = document.querySelector('[name="cie10"]').value;
            document.getElementById('print-indicaciones').textContent = document.querySelector('[name="indicaciones"]').value;
            document.getElementById('print-estudios').textContent = document.querySelector('[name="estudios"]').value;
            document.getElementById('print-proxima').textContent = document.querySelector('[name="proxima_cita"]').value;
            
            // Medicamentos
            const tbody = document.getElementById('print-medicamentos');
            tbody.innerHTML = '';
            document.querySelectorAll('.medicamento-item').forEach(item => {
                const nombre = item.querySelector('select').value;
                const cantidad = item.querySelector('input[type="number"]:nth-of-type(1)').value;
                const dias = item.querySelector('input[type="number"]:nth-of-type(2)').value;
                const posologia = item.querySelector('input[type="text"]').value;
                if (nombre) {
                    tbody.innerHTML += `<tr><td>${nombre}</td><td>${cantidad}</td><td>${dias}</td><td>${posologia}</td></tr>`;
                }
            });
            
            window.print();
        }
    </script>
</body>
</html>
