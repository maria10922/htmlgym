<?php
// Conectar a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'gym_plataforma';

$conn = new mysqli($host, $user, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT id, nombre, precio, imagen FROM productos";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    // Guardar los productos en un array
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Devolver los productos como JSON
echo json_encode($productos);
?>
