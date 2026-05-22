<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica - HealthNexus</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #000; line-height: 1.4; margin: 0; padding: 20px; background: #f0f0f0; }
        .paper { background: white; width: 210mm; min-height: 297mm; margin: 0 auto; padding: 20mm; box-shadow: 0 0 10px rgba(0,0,0,0.1); position: relative; }
        
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #2980b9; text-transform: uppercase; }
        .info-hospital { text-align: right; font-size: 12px; }

        .patient-info { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; background: #f9f9f9; padding: 10px; border: 1px solid #ddd; }
        .p-row { margin-bottom: 5px; }
        .p-label { font-weight: bold; display: inline-block; width: 100px; }

        .section-title { font-weight: bold; font-size: 16px; margin-top: 20px; margin-bottom: 10px; text-decoration: underline; }
        
        .diagnosis-box { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; min-height: 50px; }
        
        .rx-symbol { font-size: 40px; font-family: serif; font-style: italic; margin: 0; line-height: 1; }
        
        .receta-box { border-left: 4px solid #333; padding-left: 15px; margin-top: 10px; white-space: pre-wrap; min-height: 100px; }

        .footer { position: absolute; bottom: 20mm; left: 20mm; right: 20mm; display: flex; justify-content: space-between; text-align: center; margin-top: 40px; }
        .sign-line { border-top: 1px solid #000; width: 200px; padding-top: 5px; font-size: 12px; }

        /* Controles fuera de la impresión */
        .controls { position: fixed; top: 10px; right: 10px; background: #333; padding: 10px; border-radius: 5px; z-index: 1000; }
        .btn-print { background: #2980b9; color: white; border: none; padding: 10px 20px; cursor: pointer; font-family: sans-serif; font-size: 14px; border-radius: 4px; text-decoration: none; display: inline-block; }
        .btn-back { background: #e74c3c; color: white; border: none; padding: 10px 20px; cursor: pointer; font-family: sans-serif; font-size: 14px; border-radius: 4px; text-decoration: none; display: inline-block; margin-right: 10px; }

        @media print {
            body { background: white; padding: 0; }
            .paper { box-shadow: none; margin: 0; width: 100%; min-height: auto; }
            .controls { display: none; }
        }
    </style>
</head>
<body>

    <!-- Botones (No se imprimen) -->
    <div class="controls">
        <a href="/citas/agenda" class="btn-back">Volver</a>
        <button onclick="window.print()" class="btn-print"> Imprimir Receta</button>
    </div>

    <div class="paper">
        <div class="header">
            <div class="logo">HealthNexus</div>
            <div class="info-hospital">
                <strong>HOSPITAL GENERAL</strong><br>
                Av. Salud #123, Ciudad<br>
                Tel: 555-1234
            </div>
        </div>

        <div class="patient-info">
            <div class="p-row"><span class="p-label">Paciente:</span> {{ $data->paciente_nombre }}</div>
            <div class="p-row"><span class="p-label">Fecha:</span> {{ $data->created_at }}</div>
            <div class="p-row"><span class="p-label">Teléfono:</span> {{ $data->telefono }}</div>
            <div class="p-row"><span class="p-label">Médico:</span> Dr(a). {{ $data->medico_nombre }}</div>
        </div>

        <div class="section-title">DIAGNÓSTICO</div>
        <div class="diagnosis-box">
            <strong>{{ $data->diagnostico }}</strong>
            @if($data->cie10) <span style="font-size: 12px; color: #666;">(CIE-10: {{ $data->cie10 }})</span> @endif
        </div>

        @if($data->exploracion_fisica)
        <div style="font-size: 12px; margin-bottom: 15px;">
            <strong>Exploración:</strong> {{ $data->exploracion_fisica }}
        </div>
        @endif

        <div class="section-title">TRATAMIENTO MÉDICO</div>
        <div class="rx-symbol">Rx</div>
        <div class="receta-box">{{ $data->receta_medica ?: 'Sin medicamento prescrito.' }}</div>

        @if($data->indicaciones)
        <div style="margin-top: 15px; font-size: 13px;">
            <strong>Indicaciones:</strong><br>
            {{ $data->indicaciones }}
        </div>
        @endif

        <div class="footer">
            <div class="sign-line">
                Dr(a). {{ $data->medico_nombre }}<br>
                Cédula: ___________________
            </div>
            <div class="sign-line">
                Firma del Paciente<br>
                ___________________
            </div>
        </div>
    </div>

    <script>
        // Auto imprimir al cargar (opcional, mejor dejar el botón)
        // window.print();
    </script>
</body>
</html>
