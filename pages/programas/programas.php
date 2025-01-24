<?php
// Iniciar sesión para obtener datos del usuario logueado
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
  header("Location: /htmlgym/pages/programas/programas1.php");
  exit();
}

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_plataforma";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar el arreglo de programas
$programas = [];

// Realizar la consulta a la base de datos
$sql = "SELECT programa, nombre_usuario FROM registro_programas";
$resultado = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    if ($resultado->num_rows > 0) {
        // Recorrer los resultados y almacenarlos en el arreglo
        while ($fila = $resultado->fetch_assoc()) {
            $programas[] = $fila;
        }
    }
} else {
    // Manejo de errores en caso de fallo en la consulta
    die("Error en la consulta: " . $conn->error);
}

// Configurar la cabecera para devolver JSON
header('Content-Type: application/json');
echo json_encode($programas);

// Cerrar la conexión
$conn->close();
?>
