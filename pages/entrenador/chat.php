<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .chat-container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .messages {
            height: 200px;
            overflow-y: scroll;
            border: 1px solid #ff5151;
            margin-bottom: 10px;
            padding: 5px;
            display: flex;
            flex-direction: column;
            gap: 5px; /* Espacio entre los mensajes */
        }

        .message-sent {
            align-self: flex-end; /* Alinear a la derecha */
            background-color: rgb(143, 143, 143); /* Color de fondo para mensajes enviados */
            padding: 5px;
            border-radius: 5px;
            max-width: 70%; /* Limitar el ancho */
            word-wrap: break-word; /* Ajustar el texto */
        }

        .message-received {
            align-self: flex-start; /* Alinear a la izquierda */
            background-color: #ff5151; /* Color de fondo para mensajes recibidos */
            padding: 5px;
            border-radius: 5px;
            max-width: 70%; /* Limitar el ancho */
            word-wrap: break-word; /* Ajustar el texto */
        }
    </style>
    <title>Chat</title>
</head>
<body>
    <div class="chat-container">
        <h2>Chat</h2>
        <div id="messages" class="messages"></div>
        <input type="text" id="message" placeholder="Escribe tu mensaje...">
        <button id="send">Enviar</button>
    </div>

    <script>
        const sendButton = document.getElementById('send');
        const messageInput = document.getElementById('message');
        const messagesDiv = document.getElementById('messages');

        sendButton.addEventListener('click', function() {
            const message = messageInput.value;
            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'message=' + encodeURIComponent(message) + '&sender=otro' // Asegúrate de enviar el sender
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
                        msgElement.textContent = msg.message; // Acceder al contenido del mensaje
                        // Asignar clase según el sender
                        msgElement.className = msg.sender === 'yo' ? 'message-sent' : 'message-received';
                        messagesDiv.appendChild(msgElement);
                    });
                });
        }

        setInterval(loadMessages, 1000); // Cargar mensajes cada segundo
    </script>
</body>
</html>