<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Receta - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 13px; }
        .btn-dark { background: #2c3e50; }
        .btn-red { background: #e74c3c; }
        .btn-green { background: #27ae60; font-size: 16px; padding: 12px 30px; }
        .container { padding: 20px; max-width: 900px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .card h2 { color: #2c3e50; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #555; font-size: 13px; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; margin-bottom: 15px; }
        textarea { height: 80px; resize: vertical; }
        .med-row { display: grid; grid-template-columns: 2fr 1fr 2fr 1fr; gap: 10px; align-items: end; padding: 10px; background: #f8f9fa; border-radius: 5px; margin-bottom: 10px; }
        .remove-btn { background: #e74c3c; color: white; border: none; padding: 8px; border-radius: 5px; cursor: pointer; margin-bottom: 15px; }
        .add-btn { background: #2980b9; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Nueva Receta Médica</h1>
        <a href="/nivel-a" class="btn btn-dark">← Volver</a>
    </div>

    <div class="container">
        <form action="/receta/guardar" method="POST">
            @csrf
            <div class="card">
                <h2> Datos del Paciente</h2>
                <label>Nombre del Paciente *</label>
                <input type="text" name="paciente_nombre" required placeholder="Nombre completo del paciente">
                
                <label>Diagnóstico *</label>
                <input type="text" name="diagnostico" required placeholder="Diagnóstico principal">
                
                <label>Instrucciones Generales *</label>
                <textarea name="instrucciones" required placeholder="Instrucciones para el paciente..."></textarea>
            </div>

            <div class="card">
                <h2> Medicamentos</h2>
                <div id="medicamentos">
                    <div class="med-row">
                        <div>
                            <label>Medicamento</label>
                            <select name="medicamento[]" onchange="autocompletarNivel(this)">
                                <option value="">Seleccionar...</option>
                                @foreach($medicamentos as $med)
                                    <option value="{{ $med->nombre_medicamento }}" data-nivel="{{ $med->requiere_nivel_minimo }}">{{ $med->nombre_medicamento }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Cantidad</label>
                            <input type="number" name="cantidad[]" min="1" value="1">
                        </div>
                        <div>
                            <label>Indicaciones</label>
                            <input type="text" name="instrucciones_uso[]" placeholder="Ej: 1 cada 8 hrs">
                        </div>
                        <div>
                            <label>Nivel</label>
                            <input type="text" name="nivel[]" value="C" readonly style="background:#eee;">
                        </div>
                    </div>
                </div>
                <button type="button" class="add-btn" onclick="agregarMedicamento()">+ Agregar Medicamento</button>
            </div>

            <div style="text-align:center;">
                <button type="submit" class="btn btn-green"> Crear Receta y Enviar a Revisión</button>
            </div>
        </form>
    </div>

    <script>
        function agregarMedicamento() {
            const container = document.getElementById('medicamentos');
            const row = document.createElement('div');
            row.className = 'med-row';
            row.innerHTML = `
                <div>
                    <label>Medicamento</label>
                    <select name="medicamento[]" onchange="autocompletarNivel(this)">
                        <option value="">Seleccionar...</option>
                        @foreach($medicamentos as $med)
                            <option value="{{ $med->nombre_medicamento }}" data-nivel="{{ $med->requiere_nivel_minimo }}">{{ $med->nombre_medicamento }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Cantidad</label>
                    <input type="number" name="cantidad[]" min="1" value="1">
                </div>
                <div>
                    <label>Indicaciones</label>
                    <input type="text" name="instrucciones_uso[]" placeholder="Ej: 1 cada 8 hrs">
                </div>
                <div style="display:flex;gap:5px;align-items:end;">
                    <div>
                        <label>Nivel</label>
                        <input type="text" name="nivel[]" value="C" readonly style="background:#eee;">
                    </div>
                    <button type="button" class="remove-btn" onclick="this.closest('.med-row').remove()"></button>
                </div>
            `;
            container.appendChild(row);
        }

        function autocompletarNivel(select) {
            const opcion = select.options[select.selectedIndex];
            const nivel = opcion.getAttribute('data-nivel');
            const row = select.closest('.med-row');
            row.querySelector('input[name="nivel[]"]').value = nivel || 'C';
        }
    </script>
</body>
</html>
