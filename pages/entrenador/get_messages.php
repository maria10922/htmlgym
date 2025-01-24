<?php
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$db = 'gym_plataforma';
$user = 'root'; // Cambia esto por tu usuario de MySQL
$pass = ''; // Cambia esto por tu contraseña de MySQL

// Conectar a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT message, sender FROM messages ORDER BY created_at ASC";
$result = $conn->query($sql);

$messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row; // Agregar cada mensaje al array
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($messages); // Devolver los mensajes en formato JSON
?>