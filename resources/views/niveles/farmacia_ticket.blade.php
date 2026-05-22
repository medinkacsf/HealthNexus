<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Farmacia</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 14px; margin: 0; padding: 20px; background: #555; }
        .ticket { background: white; width: 80mm; margin: 0 auto; padding: 10mm; box-shadow: 0 0 10px rgba(0,0,0,0.5); text-align: center; }
        .logo { font-weight: bold; font-size: 18px; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .info { font-size: 12px; margin-bottom: 15px; text-align: left; }
        .receta { text-align: left; background: #f9f9f9; padding: 10px; border: 1px solid #eee; margin-bottom: 15px; white-space: pre-wrap; font-weight: bold; }
        .footer { font-size: 10px; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; }
        
        .btn-group { text-align: center; margin-top: 20px; }
        .btn { padding: 10px 20px; border: none; cursor: pointer; font-family: sans-serif; font-weight: bold; border-radius: 5px; color: white; text-decoration: none; display: inline-block; margin: 5px;}
        .btn-confirm { background: #27ae60; }
        .btn-cancel { background: #7f8c8d; }

        @media print {
            body { background: white; padding: 0; }
            .ticket { box-shadow: none; width: 100%; margin: 0; }
            .btn-group { display: none; }
        }
    </style>
</head>
<body>

<div class="ticket">
    <div class="logo">FARMACIA HEALTHNEXUS</div>
    <div class="info">
        <strong>Paciente:</strong> {{ $data->paciente_nombre }}<br>
        <!-- FECHA CORREGIDA AQUI -->
        <strong>Fecha:</strong> {{ date('d/m/Y H:i', strtotime($data->created_at)) }}<br>
        <strong>Médico:</strong> {{ $data->medico_nombre }}
    </div>

    <div style="text-align: left; margin-bottom: 5px;"><strong> MEDICAMENTOS:</strong></div>
    <div class="receta">{{ $data->receta_medica }}</div>

    @if($data->indicaciones)
    <div style="text-align: left; font-size: 11px; margin-bottom: 10px;">
        <strong>Indicaciones:</strong><br>
        {{ $data->indicaciones }}
    </div>
    @endif

    <div class="footer">
        <p><strong>¡Gracias por su visita!</strong></p>
        <p>Conservar este comprobante.</p>
    </div>
</div>

<div class="btn-group">
    <form action="/farmacia/confirmar/{{ $data->id }}" method="POST">
        @csrf
        <button type="button" onclick="window.print()" class="btn btn-confirm"> Imprimir Ticket</button>
        <button type="submit" class="btn btn-confirm"> Confirmar Entrega</button>
    </form>
    <a href="/farmacia" class="btn btn-cancel">Cancelar / Volver</a>
</div>

</body>
</html>
