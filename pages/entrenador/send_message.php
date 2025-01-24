<?php
$host = 'localhost'; 
$db = 'gym_plataforma';
$user = 'root';
$pass = '';

// Conectar a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['message']) && isset($_POST['sender'])) {
    $message = strip_tags($_POST['message']);
    $sender = strip_tags($_POST['sender']);
    $stmt = $conn->prepare("INSERT INTO messages (message, sender) VALUES (?, ?)");
    $stmt->bind_param("ss", $message, $sender);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
