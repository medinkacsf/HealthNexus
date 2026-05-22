<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HealthNexus - Dashboard</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; background: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h3 { margin-top: 0; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .stat-number { font-size: 32px; font-weight: bold; color: #007bff; }
        input, button { padding: 10px; margin: 5px 0; width: calc(100% - 22px); border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; }
        button:hover { background: #0056b3; }
        .alert-box { padding: 15px; border-radius: 5px; margin-top: 10px; display: none; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; display: block !important; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; display: block !important; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; display: block !important; }
        .loading { color: #666; font-style: italic; }
        .footer-link { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
        .footer-link a { color: #666; text-decoration: none; }
        .footer-link a:hover { color: #007bff; }
    </style>
</head>
<body>

    <div class="header">
        <h2> HealthNexus</h2>
        <div>
            <strong>{{ Auth::user()->name }}</strong> 
            <span style="margin-left:10px; padding:5px 10px; background:#27ae60; color:white; border-radius:5px; font-size:12px;">
                {{ Auth::user()->roles->first()?->name ?? 'Sin rol' }}
            </span>
            <form action="/logout" method="POST" style="display:inline; margin-left:10px;">
                @csrf <button type="submit" style="width:auto; background:#dc3545;">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <!-- TARJETAS SUPERIORES -->
    <div class="grid">
        <div class="card" style="text-align:center;">
            <h3>Personal Activo</h3>
            <div class="stat-number">{{ $totalUsuarios }}</div>
        </div>
        <div class="card" style="text-align:center;">
            <h3>Auditorías Hoy</h3>
            <div class="stat-number">{{ $logsHoy }}</div>
        </div>
        <div class="card" style="text-align:center;">
            <h3>Cuadro Básico</h3>
            <div class="stat-number">{{ $medicamentos }}</div>
        </div>
    </div>

    <div class="grid">
        
        <!-- MODULO IA: ALERTAS DE INVENTARIO -->
        <div class="card">
            <h3> Alertas IA (Inventario)</h3>
            <div id="alertas-container" class="loading">Cargando predicciones...</div>
            <button onclick="cargarAlertas()">Actualizar IA</button>
        </div>

        <!-- MODULO MEDICO: VALIDADOR DE RECETAS -->
        <div class="card">
            <h3> Validador Cuadro Básico</h3>
            <input type="text" id="medicamento-input" placeholder="Ej: Ibuprofeno, Morfina...">
            <button onclick="validarReceta()">Validar Receta</button>
            <div id="receta-resultado"></div>
        </div>

        <!-- MODULO SEGURIDAD: DETECTOR DE FUGAS -->
        <div class="card">
            <h3> Detector de Anomalías (Fugas)</h3>
            <input type="number" id="jeringas-input" placeholder="Jeringas usadas">
            <input type="number" id="gasas-input" placeholder="Gasas usadas">
            <button onclick="detectarFuga()">Analizar Consumo</button>
            <div id="fuga-resultado"></div>
        </div>

    </div>

    <div class="footer-link">
        <a href="/admin"> Panel de Administración</a>
    </div>

    <script>
        function getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '';
        }

        async function cargarAlertas() {
            const res = await fetch('/ia/alertas');
            const data = await res.json();
            const container = document.getElementById('alertas-container');
            
            if(data.error) {
                container.innerHTML = '<div class="alert-box danger">Error: ' + data.error + '</div>';
                return;
            }

            let html = '';
            if(data.alertas && data.alertas.length > 0) {
                data.alertas.forEach(a => {
                    const color = a.nivel === 'rojo' ? 'danger' : 'warning';
                    html += '<div class="alert-box ' + color + '"><strong>' + a.titulo + '</strong><br>' + a.mensaje + '</div>';
                });
            } else {
                html = '<div class="alert-box success">Todo normal. Sin quiebres pronosticados.</div>';
            }
            container.innerHTML = html;
        }

        async function validarReceta() {
            const med = document.getElementById('medicamento-input').value;
            if(!med) return;
            
            const res = await fetch('/ia/validar-receta', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': getCsrfToken() 
                },
                body: JSON.stringify({ medicamento: med })
            });
            const data = await res.json();
            const container = document.getElementById('receta-resultado');
            
            const color = data.estatus === 'APROBADA' ? 'success' : 'danger';
            container.innerHTML = '<div class="alert-box ' + color + '"><strong>' + data.estatus + '</strong><br>' + data.mensaje + '<br>Nivel mínimo: ' + data.nivel_minimo + ' | Costo: $' + data.costo + '</div>';
        }

        async function detectarFuga() {
            const jeringas = document.getElementById('jeringas-input').value;
            const gasas = document.getElementById('gasas-input').value;
            if(!jeringas || !gasas) return;

            const res = await fetch('/ia/detectar-fuga', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': getCsrfToken() 
                },
                body: JSON.stringify({ jeringas: jeringas, gasas: gasas })
            });
            const data = await res.json();
            const container = document.getElementById('fuga-resultado');
            
            const color = data.estatus === 'NORMAL' ? 'success' : 'danger';
            container.innerHTML = '<div class="alert-box ' + color + '"><strong>' + data.estatus + '</strong><br>' + data.mensaje + '</div>';
        }

        cargarAlertas();
    </script>
</body>
</html>