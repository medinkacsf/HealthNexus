<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistente IA - HealthNexus</title>
    <style>
        body { font-family: Arial; background-color: #f0f4f8; margin: 0; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; max-width: 600px; margin-left: auto; margin-right: auto; }
        h1, h2 { color: #2c3e50; }
        .symptom { display: flex; justify-content: space-between; padding: 15px; border-bottom: 1px solid #eee; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; color: white; background: #3498db; width: 100%; font-size: 16px; margin-top: 20px;}
        .btn:hover { background: #2980b9; }
        .btn-back { background: #7f8c8d; text-decoration: none; padding: 10px 15px; }
        .result-box { background: #e8f8f5; border-left: 5px solid #27ae60; padding: 20px; margin-top: 20px; border-radius: 5px; }
        .error-box { background: #fadbd8; border-left: 5px solid #e74c3c; padding: 20px; margin-top: 20px; border-radius: 5px; color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Asistente de Diagnóstico (IA)</h1>
        <a href="{{ route('dashboard') }}" class="btn-back" style="text-decoration:none; color:white;">Volver</a>
    </div>

    <div class="card">
        <h2>Evaluación de Síntomas</h2>
        <form method="POST" action="{{ route('ia.predict') }}">
            @csrf
            <div class="symptom">
                <strong>¿Fiebre?</strong>
                <select name="fiebre"><option value="0">No</option><option value="1">Sí</option></select>
            </div>
            <div class="symptom">
                <strong>¿Tos Seca?</strong>
                <select name="tos_seca"><option value="0">No</option><option value="1">Sí</option></select>
            </div>
            <div class="symptom">
                <strong>¿Dolor de Cabeza?</strong>
                <select name="dolor_cabeza"><option value="0">No</option><option value="1">Sí</option></select>
            </div>
            <button type="submit" class="btn">Consultar a la IA</button>
        </form>

        @if(isset($prediccion))
            @if(isset($prediccion['error']))
                <div class="error-box"><strong>Error:</strong> {{ $prediccion['error'] }}</div>
            @else
                <div class="result-box">
                    <h3 style="margin-top:0; color:#27ae60;"> Resultado del Motor de IA</h3>
                    <p><strong>Diagnóstico:</strong> {{ $prediccion['prediccion_diagnostico'] }}</p>
                    <hr style="border:0; border-top:1px solid #ccc; margin:10px 0;">
                    <p><strong>Probabilidades:</strong></p>
                    <ul style="list-style:none; padding:0;">
                        @foreach($prediccion['probabilidades_detalladas'] as $enfermedad => $probabilidad)
                            <li>{{ ucfirst($enfermedad) }}: {{ $probabilidad }}%</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>
</body>
</html>
