k<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SuperAdmin - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f0f4f8; height: 100vh; display: flex; flex-direction: column; }
        .header { background: linear-gradient(135deg, #1a252f, #2c3e50); color: white; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; }
        .btn { padding: 7px 12px; border-radius: 5px; border: none; cursor: pointer; text-decoration: none; color: white; font-size: 12px; }
        .btn-red { background: #e74c3c; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .sidebar { width: 220px; background: white; padding: 15px; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.05); }
        .sidebar h3 { color: #2c3e50; margin-bottom: 15px; font-size: 14px; }
        .nav-item { padding: 10px 12px; margin-bottom: 3px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; text-decoration: none; color: #333; transition: background 0.2s; }
        .nav-item:hover { background: #f0f0f0; }
        .nav-item.active { background: #eaf2f8; color: #2980b9; font-weight: bold; }
        .content { flex: 1; overflow-y: auto; padding: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat { background: white; padding: 18px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); text-align: center; }
        .stat-num { font-size: 28px; font-weight: bold; }
        .stat-label { color: #7f8c8d; font-size: 11px; margin-top: 3px; }
        .stat-rojo .stat-num { color: #e74c3c; }
        .stat-verde .stat-num { color: #27ae60; }
        .stat-azul .stat-num { color: #2980b9; }
        .stat-amarillo .stat-num { color: #f39c12; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
        .card h3 { color: #2c3e50; margin-bottom: 15px; font-size: 15px; border-bottom: 2px solid #eee; padding-bottom: 8px; }
        .barra { height: 24px; background: #ecf0f1; border-radius: 4px; margin-bottom: 8px; overflow: hidden; }
        .barra-fill { height: 100%; border-radius: 4px; transition: width 0.5s; }
        .barra-label { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 3px; }
        .alerta { padding: 12px; border-radius: 8px; margin-bottom: 10px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alerta-roja { background: #fdedec; border-left: 4px solid #e74c3c; color: #c0392b; }
        .alerta-amarilla { background: #fef9e7; border-left: 4px solid #f39c12; color: #7d6608; }
        .alerta-verde { background: #eafaf1; border-left: 4px solid #27ae60; color: #1e8449; }
        .chat-container { height: 350px; display: flex; flex-direction: column; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 12px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px; }
        .msg { margin-bottom: 10px; display: flex; gap: 8px; }
        .msg-bot { justify-content: flex-start; }
        .msg-user { justify-content: flex-end; }
        .msg-bubble { max-width: 85%; padding: 10px 14px; border-radius: 10px; font-size: 13px; line-height: 1.4; white-space: pre-line; }
        .msg-bot .msg-bubble { background: white; border: 1px solid #ddd; }
        .msg-user .msg-bubble { background: #2c3e50; color: white; }
        .msg-fuente { font-size: 10px; color: #aaa; margin-top: 2px; }
        .chat-input { display: flex; gap: 8px; }
        .chat-input input { flex: 1; padding: 10px 14px; border: 2px solid #ddd; border-radius: 20px; font-size: 13px; outline: none; }
        .chat-input input:focus { border-color: #2c3e50; }
        .chat-input button { background: #2c3e50; color: white; border: none; padding: 10px 18px; border-radius: 20px; cursor: pointer; font-size: 15px; }
        .quick-btns { display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap; }
        .quick-btn { background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 15px; cursor: pointer; font-size: 11px; }
        .quick-btn:hover { background: #f0f0f0; }
        .typing { color: #888; font-style: italic; padding: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h1> SuperAdmin - HealthNexus</h1>
        <div style="display:flex;gap:8px;align-items:center;">
            <span style="font-size:12px;opacity:0.7;">{{ $user->name }}</span>
            <form action="/logout" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-red">Salir</button></form>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <h3> Menú</h3>
            <a href="/superadmin" class="nav-item active"> Dashboard</a>
            <a href="/admin" class="nav-item" target="_blank"> Administración</a>
            <a href="/auditoria" class="nav-item" target="_blank"> Auditoría</a>
            <a href="/expedientes" class="nav-item" target="_blank"> Expedientes</a>
            <a href="/farmacia" class="nav-item" target="_blank"> Farmacia</a>
            <a href="/dashboard" class="nav-item" target="_blank"> Monitor IA</a>
            <a href="#chat" class="nav-item"> Chat Ejecutivo</a>
        </div>

        <div class="content">
            <div class="stats">
                <div class="stat stat-azul"><div class="stat-num">45</div><div class="stat-label">Consultas Hoy</div></div>
                <div class="stat stat-verde"><div class="stat-num">12</div><div class="stat-label">Ingresos</div></div>
                <div class="stat stat-amarillo"><div class="stat-num">8</div><div class="stat-label">Egresos</div></div>
                <div class="stat stat-rojo"><div class="stat-num">{{ $stats['alertas_stock'] }}</div><div class="stat-label">Alertas IA</div></div>
            </div>

            <div class="grid">
                <div class="card">
                    <h3> Consultas por Especialidad (Hoy)</h3>
                    <div class="barra-label"><span>Cardiología</span><span>23</span></div>
                    <div class="barra"><div class="barra-fill" style="width:85%;background:#e74c3c;"></div></div>
                    <div class="barra-label"><span>Traumatología</span><span>18</span></div>
                    <div class="barra"><div class="barra-fill" style="width:67%;background:#e67e22;"></div></div>
                    <div class="barra-label"><span>Neurología</span><span>12</span></div>
                    <div class="barra"><div class="barra-fill" style="width:45%;background:#2980b9;"></div></div>
                    <div class="barra-label"><span>Neumología</span><span>9</span></div>
                    <div class="barra"><div class="barra-fill" style="width:33%;background:#27ae60;"></div></div>
                    <div class="barra-label"><span>Ortopedia</span><span>7</span></div>
                    <div class="barra"><div class="barra-fill" style="width:26%;background:#8e44ad;"></div></div>
                </div>

                <div class="card">
                    <h3> Alertas Inteligentes IA</h3>
                    <div class="alerta alerta-roja"> <strong>Anomalía Crítica</strong> - Traumatología: Consumo 340% sobre promedio</div>
                    <div class="alerta alerta-amarillo"> <strong>Stock Bajo</strong> - Morfina 10mg: 8 unidades (mín: 5)</div>
                    <div class="alerta alerta-amarillo"> <strong>Stock Bajo</strong> - Amoxicilina 500mg: 3 unidades (mín: 15)</div>
                    <div class="alerta alerta-verde"> <strong>Estable</strong> - Cardiología y Neumología operando normal</div>
                </div>
            </div>

            <div class="grid">
                <div class="card">
                    <h3> Predicción de Inventario (7 días)</h3>
                    <div class="barra-label"><span>Ibuprofeno 600mg</span><span style="color:#27ae60;">Stock OK (12 días)</span></div>
                    <div class="barra"><div class="barra-fill" style="width:80%;background:#27ae60;"></div></div>
                    <div class="barra-label"><span>Paracetamol 500mg</span><span style="color:#27ae60;">Stock OK (25 días)</span></div>
                    <div class="barra"><div class="barra-fill" style="width:95%;background:#27ae60;"></div></div>
                    <div class="barra-label"><span>Morfina 10mg</span><span style="color:#e74c3c;"> 2 días</span></div>
                    <div class="barra"><div class="barra-fill" style="width:15%;background:#e74c3c;"></div></div>
                    <div class="barra-label"><span>Amoxicilina 500mg</span><span style="color:#e74c3c;"> 0.5 días</span></div>
                    <div class="barra"><div class="barra-fill" style="width:5%;background:#e74c3c;"></div></div>
                </div>

                <div class="card">
                    <h3> Resumen Semanal IA</h3>
                    <div style="font-size:13px;line-height:1.8;">
                        <p> <strong>Consultas:</strong> +8% vs semana pasada (312 total)</p>
                        <p> <strong>Ingresos estimados:</strong> $8,450,000 MXN</p>
                        <p> <strong>Ocupación:</strong> 62% (75/120 camas)</p>
                        <p> <strong>Anomalías detectadas:</strong> 3 esta semana</p>
                        <p> <strong>Quiebres evitados:</strong> 2 (IA predijo correctamente)</p>
                        <p> <strong>Tiempo promedio estancia:</strong> 3.2 días (-0.3 vs anterior)</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3> Asistente Ejecutivo IA</h3>
                <div class="quick-btns">
                    <button class="quick-btn" onclick="enviar('Resumen del hospital')"> Resumen</button>
                    <button class="quick-btn" onclick="enviar('Pacientes atendidos')"> Pacientes</button>
                    <button class="quick-btn" onclick="enviar('Ingresos y egresos')"> Ingresos</button>
                    <button class="quick-btn" onclick="enviar('Anomalías detectadas')"> Anomalías</button>
                    <button class="quick-btn" onclick="enviar('Predicción de inventario')"> Inventario</button>
                    <button class="quick-btn" onclick="enviar('Finanzas del día')"> Finanzas</button>
                    <button class="quick-btn" onclick="enviar('Estado del personal')">‍ Personal</button>
                    <button class="quick-btn" onclick="enviar('Generar reporte diario')"> Reporte</button>
                </div>
                <div class="chat-container">
                    <div class="chat-messages" id="chatMessages">
                        <div class="msg msg-bot">
                            <div>
                                <div class="msg-bubble">Hola, Administrador. Soy tu asistente IA ejecutivo. Puedo generarte resúmenes, reportes y análisis en tiempo real del hospital.</div>
                                <div class="msg-fuente">Sistema</div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-input">
                        <input type="text" id="chatInput" placeholder="Pregunta ejecutiva..." onkeypress="if(event.key==='Enter')enviarMsg()">
                        <button onclick="enviarMsg()"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviarMsg() {
            const input = document.getElementById('chatInput');
            const texto = input.value.trim();
            if (!texto) return;
            agregar(texto, 'user');
            input.value = '';
            const cm = document.getElementById('chatMessages');
            cm.innerHTML += '<div class="typing" id="typing">Analizando...</div>';
            cm.scrollTop = cm.scrollHeight;
            try {
                const res = await fetch('http://127.0.0.1:8000/chatbot-admin', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ pregunta: texto })
                });
                const data = await res.json();
                document.getElementById('typing')?.remove();
                agregar(data.respuesta, 'bot', data.fuente);
            } catch (e) {
                document.getElementById('typing')?.remove();
                agregar('Error de conexión con el motor IA.', 'bot', 'Error');
            }
        }
        function enviar(t) {
            document.getElementById('chatInput').value = t;
            enviarMsg();
        }
        function agregar(texto, tipo, fuente) {
            const cm = document.getElementById('chatMessages');
            const d = document.createElement('div');
            d.className = `msg msg-${tipo}`;
            d.innerHTML = `<div><div class="msg-bubble">${texto}</div>${fuente ? `<div class="msg-fuente"> ${fuente}</div>` : ''}</div>`;
            cm.appendChild(d);
            cm.scrollTop = cm.scrollHeight;
        }
    </script>
</body>
</html>
