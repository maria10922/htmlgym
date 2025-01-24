<?php
header('Content-Type: application/json');
include 'conexion.php'; // Ajusta según tu archivo de conexión

// Decodificar los datos JSON enviados
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos.']);
    exit;
}

$id = $data['id'];
$nombre = $data['nombre'];
$precio = $data['precio'];
$imagen = $data['imagen'];
$cantidad = $data['cantidad'];

// Insertar en la base de datos
$conn = new mysqli('localhost', 'root', '', 'gym_plataforma'); // Ajusta según tu configuración

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos.']));
}

$sql = "INSERT INTO carrito (id, nombre_producto, precio_producto, imagen_producto, fecha_agregado, cantidad) 
        VALUES (?, ?, ?, ?, NOW(), ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isdsi', $id, $nombre, $precio, $imagen, $cantidad);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar al carrito: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
