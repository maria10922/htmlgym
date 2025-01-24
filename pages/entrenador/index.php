<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #00010E;
            margin: 0;
            padding: 0;
            color: white;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0);
            position: relative;
            z-index: 2;
            border-bottom: 0.1px solid #ffffff5e;
        }

        header nav a {
            color: #ffffff;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .chat-container {
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color:rgba(26, 0, 99, 0);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            height: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0);
        }
/* Barra de desplazamiento personalizada para el contenedor de mensajes */
.messages {
    flex-grow: 1;
    overflow-y: scroll;
    border: 1px solid #444;
    margin-bottom: 10px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: rgba(0, 4, 27, 0.52);
    border-radius: 5px;
}

/* Barra de desplazamiento personalizada */
.messages::-webkit-scrollbar {
    width: 8px; /* Ancho de la barra de desplazamiento */
}

.messages::-webkit-scrollbar-track {
    background-color:rgba(10, 0, 34, 0); /* Fondo de la pista de la barra */
    border-radius: 10px;
}

.messages::-webkit-scrollbar-thumb {
    background-color:rgb(5, 0, 53); /* Color del pulgar (la parte que se mueve) */
    border-radius: 10px;
    border: 2px solid #222; /* Borde de la barra */
}

.messages::-webkit-scrollbar-thumb:hover {
    background-color:rgb(10, 0, 99); /* Color del pulgar al pasar el ratón */
}
        .messages {
            flex-grow: 1;
            overflow-y: scroll;
            border: 1px solid #444;
            margin-bottom: 10px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color:rgba(0, 4, 27, 0);
            border-radius: 5px;
        }

        .message-sent {
            align-self: flex-end;
            background-color:rgb(4, 0, 61);
            color: white;
            padding: 8px 12px;
            border-radius: 15px 15px 0 15px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .message-received {
            align-self: flex-start;
            background-color: #444;
            color: white;
            padding: 8px 12px;
            border-radius: 15px 15px 15px 0;
            max-width: 70%;
            word-wrap: break-word;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
        }

        #message {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color:rgba(0, 20, 75, 0.57);
            color: white;
        }

        #send, #delete {
            border: none;
            padding: 10px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        #send {
            background-color:rgb(16, 0, 158);
        }

        #send:hover {
            background-color:rgb(53, 42, 145);
        }

        #delete {
            background-color: #ff5151;
        }

        #delete:hover {
            background-color: #e04040;
        }

        footer {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0);
            border-top: 0.1px solid #ffffff5e;
        }

        footer p {
            font-size: 0.9em;
            color: #ffffff;
        }
        .contador {
      top: -10px;
      right: -10px;
      background-color: rgba(255, 0, 0, 0.7);
      color: white;
      border-radius: 50%;
      padding: 5px 5px;
      font-size: 14px;
    }
    </style>
    <title>Chat</title>
</head>
<body>
    <!-- Header de navegación -->
    <header>
        <h2>MUSCLEGYM</h2>
        <nav>
            <a href="/htmlgym/pages/inicio/dashboard.html">Inicio</a>
            <a href="/htmlgym/pages/acerca_de/acerca.html">Acerca de</a>
            <a href="/htmlgym/pages/programas/programas.php">Programas</a>
            <a href="/htmlgym/pages/tienda/tienda.html">Tienda</a>
            <a href="/htmlgym/pages/membrecia/membresia.html">Membresía</a>
            <a href="/htmlgym/pages/perfil/perfil1.php">Perfil</a>
            <a href="/htmlgym/pages/index/login.html">Acceso</a>
            <a href="/htmlgym/pages/tienda/carrito.html" id="carritoMenu">🛒<span id="contadorCarrito" class="contador">0</span></a>
            <a href="/htmlgym/pages/entrenador/chat.php">Chat con entrenador</a>
            <a href="/htmlgym/pages/entrenador/chat.php">Entrenador</a>
        </nav>
    </header>

    <div class="chat-container">
        <h2>Chat</h2>
        <div id="messages" class="messages"></div>
        <div class="buttons-container">
            <input type="text" id="message" placeholder="Escribe tu mensaje...">
            <button id="send">Enviar</button>
        </div>
    </div>

    <footer>
        <p>© 2024 Gym Plataforma. Todos los derechos reservados.</p>
    </footer>

    <script>
        const sendButton = document.getElementById('send');
        const deleteButton = document.getElementById('delete');
        const messageInput = document.getElementById('message');
        const messagesDiv = document.getElementById('messages');

        sendButton.addEventListener('click', function () {
            const message = messageInput.value;
            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'message=' + encodeURIComponent(message) + '&sender=yo'
                }).then(() => {
                    messageInput.value = '';
                    loadMessages();
                });
            }
        });

        function loadMessages() {
            fetch('get_messages.php')
                .then(response => response.json())
                .then(data => {
                    messagesDiv.innerHTML = '';
                    data.forEach(msg => {
                        const msgElement = document.createElement('div');
                        msgElement.textContent = msg.message;
                        msgElement.className = msg.sender === 'yo' ? 'message-sent' : 'message-received';
                        messagesDiv.appendChild(msgElement);
                    });
                });
        }

        setInterval(loadMessages, 1000);
        // Captura el evento 'Enter' para enviar mensajes
messageInput.addEventListener('keypress', function (event) {
    if (event.key === 'Enter') { // Comprueba si la tecla presionada es Enter
        const message = messageInput.value;
        if (message) {
            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'message=' + encodeURIComponent(message) + '&sender=yo'
            }).then(() => {
                messageInput.value = ''; // Limpia el campo de entrada
                loadMessages(); // Recarga los mensajes
            });
        }
    }
});
 // Actualizar el contador del carrito
 function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    document.getElementById('contadorCarrito').textContent = carrito.reduce(
      (total, item) => total + item.cantidad,
      0
    );
  }
          // Cargar carrito desde localStorage al cargar la página
          document.addEventListener('DOMContentLoaded', () => {
      actualizarContadorCarrito();
        })
    </script>
</body>
</html>
