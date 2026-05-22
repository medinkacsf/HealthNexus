<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica</title>
    <style>
        @media print { .no-print { display: none; } }
        body { font-family: Arial; max-width: 800px; margin: 0 auto; padding: 40px; }
        .header-receta { border-bottom: 3px solid #2c3e50; padding-bottom: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: bold; color: #2c3e50; }
        .titulo { font-size: 18px; color: #7f8c8d; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .info-box { background: #f8f9fa; padding: 10px 15px; border-radius: 5px; }
        .info-label { font-size: 11px; color: #888; text-transform: uppercase; }
        .info-value { font-size: 14px; font-weight: bold; }
        .seccion { margin-bottom: 20px; }
        .seccion h3 { color: #2c3e50; border-left: 4px solid #27ae60; padding-left: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #2c3e50; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        .firma-area { margin-top: 40px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 30px; }
        .firma-box { text-align: center; border-top: 2px solid #333; padding-top: 10px; }
        .firma-nombre { font-weight: bold; font-size: 13px; }
        .firma-rol { font-size: 11px; color: #888; }
        .no-print { margin-bottom: 20px; }
        .btn-print { background: #8e44ad; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .btn-print:hover { background: #7d3c98; }
        .pie { margin-top: 30px; text-align: center; font-size: 11px; color: #aaa; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn-print" onclick="window.print()"> IMPRIR RECETA</button>
        <button class="btn-print" style="background:#e74c3c;" onclick="window.close()"> Cerrar</button>
    </div>

    <div class="header-receta">
        <div>
            <div class="logo"> HealthNexus</div>
            <div class="titulo">Receta Médica Electrónica</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:12px;">Folio: <strong>#{{ str_pad($receta->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
            <div style="font-size:12px;">Fecha: {{ date('d/m/Y H:i', strtotime($receta->created_at)) }}</div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">Paciente</div>
            <div class="info-value">{{ $receta->paciente_nombre }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Médico Prescriptor</div>
            <div class="info-value">{{ $receta->doctor_creador }}</div>
        </div>
    </div>

    <div class="seccion">
        <h3>Diagnóstico</h3>
        <p>{{ $receta->diagnostico }}</p>
    </div>

    <div class="seccion">
        <h3>Medicamentos Recetados</h3>
        <table>
            <tr><th>Medicamento</th><th>Cantidad</th><th>Indicaciones</th><th>Nivel</th></tr>
            @foreach($items as $item)
            <tr>
                <td><strong>{{ $item->medicamento }}</strong></td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->instrucciones_uso }}</td>
                <td>Nivel {{ $item->requiere_nivel }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="seccion">
        <h3>Instrucciones Generales</h3>
        <p>{{ $receta->instrucciones }}</p>
    </div>

    <div class="firma-area">
        <div class="firma-box">
            <div class="firma-nombre">{{ $receta->doctor_creador ?? '________________' }}</div>
            <div class="firma-rol">Médico Prescriptor</div>
        </div>
        <div class="firma-box">
            <div class="firma-nombre">{{ $receta->firma_nivel_b ?? '________________' }}</div>
            <div class="firma-rol">Revisión Nivel B</div>
        </div>
        <div class="firma-box">
            <div class="firma-nombre">{{ $receta->firma_nivel_a ?? '________________' }}</div>
            <div class="firma-rol">Autorización Nivel A</div>
        </div>
    </div>

    <div class="pie">
        Documento generado por HealthNexus Enterprise OS — {{ date('d/m/Y H:i') }} — Registro inmutable
    </div>
</body>
</html>
