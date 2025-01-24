<?php
// Incluir el archivo de conexión a la base de datos
include 'db_connect.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $nombre, $email, $mensaje);
        
        if ($stmt->execute()) {
            echo "¡Gracias por tu mensaje! Nos pondremos en contacto pronto.";
        } else {
            echo "Hubo un error. Por favor, intenta nuevamente.";
        }
        
        // Cerrar la sentencia
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>
