<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Jefe - HealthNexus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; height: 100vh; display: flex; flex-direction: column; }
        .header { background: linear-gradient(135deg, #c0392b, #e74c3c); color: white; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .header h1 { font-size: 18px; }
        .header-info { display: flex; gap: 12px; align-items: center; font-size: 13px; }
        .badge-jefe { background: rgba(255,255,255,0.2); padding: 5px 14px; border-radius: 20px; font-size: 12px; }
        .badge-rol { background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 12px; font-size: 11px; opacity: 0.8; }
        .btn { padding: 7px 14px; border-radius: 5px; border: none; cursor: pointer; font-size: 12px; text-decoration: none; color: white; }
        .btn-red { background: #c0392b; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .sidebar { width: 220px; background: white; padding: 15px; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.05); }
        .sidebar-section { margin-bottom: 20px; }
        .sidebar-title { font-size: 10px; color: #999; text-transform: uppercase; letter-spacing: 1.5px; padding: 0 12px; margin-bottom: 8px; font-weight: 600; }
        .nav-item { padding: 10px 12px; margin-bottom: 3px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; text-decoration: none; color: #333; transition: all 0.2s; }
        .nav-item:hover { background: #f8f9fa; }
        .nav-item.active { background: #fdedec; color: #c0392b; font-weight: bold; }
        .nav-icon { font-size: 16px; }
        .content { flex: 1; padding: 20px; overflow-y: auto; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .card { background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); overflow: hidden; }
        .card-header { background: #f8f9fa; padding: 12px 16px; border-bottom: 2px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { color: #2c3e50; font-size: 14px; }
        .card-badge { background: #e74c3c; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; }
        .card-badge-verde { background: #27ae60; }
        .card-badge-azul { background: #2980b9; }
        .card-body { padding: 0; }
        .table-list { width: 100%; }
        .table-list tr { border-bottom: 1px solid #f0f0f0; }
        .table-list td { padding: 10px 16px; font-size: 13px; }
        .table-list tr:last-child { border-bottom: none; }
        .estado { padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        .estado-pendiente { background: #fff3cd; color: #856404; }
        .estado-confirmada { background: #d4edda; color: #155724; }
        .estado-atendida { background: #cce5ff; color: #004085; }
        .estado-cancelada { background: #f8d7da; color: #721c24; }
        .estado-firmada { background: #d4edda; color: #155724; }
        .empty-state { padding: 30px; text-align: center; color: #aaa; font-size: 13px; }
        .section { background: white; border-radius: 10px; padding: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 15px; }
        .section h2 { color: #2c3e50; margin-bottom: 12px; font-size: 15px; }
        .chat-container { height: 280px; display: flex; flex-direction: column; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 12px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px; }
        .msg { margin-bottom: 10px; display: flex; gap: 8px; }
        .msg-bot { justify-content: flex-start; }
        .msg-user { justify-content: flex-end; }
        .msg-bubble { max-width: 80%; padding: 10px 14px; border-radius: 10px; font-size: 13px; line-height: 1.4; white-space: pre-line; }
        .msg-bot .msg-bubble { background: white; border: 1px solid #ddd; }
        .msg-user .msg-bubble { background: #c0392b; color: white; }
        .msg-fuente { font-size: 10px; color: #aaa; margin-top: 2px; }
        .chat-input { display: flex; gap: 8px; }
        .chat-input input { flex: 1; padding: 10px 14px; border: 2px solid #ddd; border-radius: 20px; font-size: 13px; outline: none; }
        .chat-input input:focus { border-color: #c0392b; }
        .chat-input button { background: #c0392b; color: white; border: none; padding: 10px 18px; border-radius: 20px; cursor: pointer; font-size: 14px; }
        .chat-input button:hover { background: #a93226; }
        .quick-btns { display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap; }
        .quick-btn { background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 15px; cursor: pointer; font-size: 11px; }
        .quick-btn:hover { background: #f0f0f0; }
        .typing { color: #888; font-style: italic; padding: 6px; }
        .btn-whatsapp { background: #25d366; color: white; border: none; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-size: 13px; font-weight: bold; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; margin-top: 8px; }
        .btn-whatsapp:hover { background: #128c7e; }
    </style>
</head>
<body>
    <div class="header">
        <h1> HealthNexus - Médico Jefe</h1>
        <div class="header-info">
            <span class="badge-jefe">👨‍ {{ $user->name }}</span>
            <span class="badge-rol">Nivel A</span>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-red">Salir</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="sidebar-section">
                <div class="sidebar-title">Consultas</div>
                <a href="/nivel-a" class="nav-item active"><span class="nav-icon">📊</span> Dashboard</a>
                <a href="/citas/agenda" class="nav-item"><span class="nav-icon">📱</span> Agenda</a>
                <a href="/expedientes" class="nav-item"><span class="nav-icon">📁</span> Expedientes</a>
                <a href="/expediente/crear" class="nav-item"><span class="nav-icon">➕</span> Nuevo Paciente</a>
                <a href="/receta/crear" class="nav-item"><span class="nav-icon">📝</span> Nueva Receta</a>
                <a href="/medicamentos" class="nav-item"><span class="nav-icon">🧪</span> Medicamentos</a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Pacientes</div>
                <a href="/nivel-a/pacientes" class="nav-item"><span class="nav-icon">💳</span> Mis Pacientes</a>
                <a href="/nivel-a/presupuestos/crear" class="nav-item"><span class="nav-icon"></span> Nuevo Presupuesto</a>
                <a href="/nivel-a/servicios" class="nav-item"><span class="nav-icon"></span> Ver Servicios</a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Sistema</div>
                <a href="/nivel-a/supervision" class="nav-item"><span class="nav-icon">👁</span> Supervisión</a>
            <a href="#chat" class="nav-item"><span class="nav-icon">🤖</span> Chat IA</a>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
            @endif

            <!-- CITAS Y RECETAS -->
            <div class="grid">
                <div class="card">
                    <div class="card-header">
                        <h3>📱 Citas WhatsApp</h3>
                        <span class="card-badge">{{ $citas_pendientes }} pendientes</span>
                    </div>
                    <div class="card-body">
                        @if(count($ultimas_citas) > 0)
                        <table class="table-list">
                            @foreach($ultimas_citas as $cita)
                            <tr>
                                <td>
                                    <strong>{{ $cita->paciente_nombre }}</strong><br>
                                    <small style="color:#888;">{{ $cita->motivo ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="estado estado-{{ $cita->estado ?? 'pendiente' }}">{{ ucfirst($cita->estado ?? 'pendiente') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <div class="empty-state">Sin citas hoy</div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3> Últimas Recetas</h3>
                        <span class="card-badge card-badge-verde">{{ $recetas_firmadas }} firmadas</span>
                    </div>
                    <div class="card-body">
                        @if(count($ultimas_recetas) > 0)
                        <table class="table-list">
                            @foreach($ultimas_recetas as $rec)
                            <tr>
                                <td>
                                    <strong>Receta #{{ $rec->id }}</strong><br>
                                    <small style="color:#888;">{{ $rec->paciente_nombre ?? 'Paciente' }}</small>
                                </td>
                                <td>
                                    <span class="estado estado-{{ $rec->estado ?? 'pendiente' }}">{{ ucfirst($rec->estado ?? 'pendiente') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <div class="empty-state">Sin recetas</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- NOTAS POR FIRMAR -->
            @if($pendientes > 0)
            <div class="card" style="border-left: 4px solid #e74c3c;">
                <div class="card-header" style="background:#fdedec;">
                    <h3 style="✍ Notas por Firmar</h3>
                    <span class="card-badge">{{ $pendientes }} pendientes</span>
                </div>
                <div class="card-body" style="padding:16px;">
                    <div style="font-size:13px;color:#e74c3c;font-weight:600;">Tiene {{ $pendientes }} nota(s) esperando su firma como Médico Jefe</div>
                </div>
            @endif

            <!-- CHATBOT IA -->
            <div class="section" id="chat">
                <h2>🤖 Asistente IA</h2>
                <a href="https://wa.me/527208321873?text=Hola%2C%20deseo%20agendar%20una%20cita" target="_blank" class="btn-whatsapp">📱 Agendar Cita por WhatsApp</a>
                <div class="quick-btns" style="margin-top:12px;">
                    <button class="quick-btn" onclick="enviarRapido('Cuadro basico')"> Cuadro Básico</button>
                    <button class="quick-btn" onclick="enviarRapido('Protocolo cefalea')"> Cefalea</button>
                    <button class="quick-btn" onclick="enviarRapido('Dolor abdominal')"> Dolor Abdominal</button>
                    <button class="quick-btn" onclick="enviarRapido('Agendar cita')">📱 Agendar Cita</button>
                </div>
                <div class="chat-container">
                    <div class="chat-messages" id="chatMessages">
                        <div class="msg msg-bot">
                            <div>
                                <div class="msg-bubble">Hola, Dr. {{ explode(' ', $user->name)[0] }}. Puedo consultar medicamentos y protocolos.</div>
                                <div class="msg-fuente">Sistema</div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-input">
                        <input type="text" id="chatInput" placeholder="Escribe tu consulta..." onkeypress="if(event.key==='Enter')enviarMensaje()">
                        <button onclick="enviarMensaje()">➤</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enviarMensaje() {
            const input = document.getElementById('chatInput');
            const texto = input.value.trim();
            if (!texto) return;
            agregarMensaje(texto, 'user');
            input.value = '';
            const cm = document.getElementById('chatMessages');
            cm.innerHTML += '<div class="typing" id="typing">🤔 Pensando...</div>';
            cm.scrollTop = cm.scrollHeight;
            try {
                const res = await fetch('http://127.0.0.1:8000/chatbot-mejorado', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ pregunta: texto })
                });
                const data = await res.json();
                document.getElementById('typing')?.remove();
                agregarMensaje(data.respuesta, 'bot', data.fuente);
            } catch (e) {
                document.getElementById('typing')?.remove();
                agregarMensaje('Error de conexión.', 'bot', 'Error');
            }
        }
        function enviarRapido(t) { document.getElementById('chatInput').value = t; enviarMensaje(); }
        function agregarMensaje(texto, tipo, fuente) {
            const cm = document.getElementById('chatMessages');
            const d = document.createElement('div');
            d.className = `msg msg-${tipo}`;
            let html = '<div class="msg-bubble">' + texto + '</div>';
            if (texto.includes('wa.me') || texto.includes('whatsapp')) {
                html += '<a href="https://wa.me/527208321873?text=Hola%2C%20deseo%20agendar%20una%20cita" target="_blank" class="btn-whatsapp">📱 Agendar por WhatsApp</a>';
            }
            html += fuente ? '<div class="msg-fuente">📊 ' + fuente + '</div>' : '';
            d.innerHTML = '<div>' + html + '</div>';
            cm.appendChild(d);
            cm.scrollTop = cm.scrollHeight;
        }
    </script>
</body>
</html>
