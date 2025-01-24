<?php
// Configuración de conexión con la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$nombreBD = 'gym_plataforma';

// Establecer la conexión con la base de datos
$conexion = new mysqli($host, $usuario, $clave, $nombreBD);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario con los datos del producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Subir la imagen
    $imagen = '';  // Inicializar la variable imagen

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Definir la ruta donde se guardará la imagen
        $directorioDestino = 'uploads/';
        $imagenNombre = basename($_FILES['imagen']['name']);
        $rutaDestino = $directorioDestino . $imagenNombre;

        // Mover la imagen al directorio de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            // Si la imagen se sube correctamente, guardar la ruta en la base de datos
            $imagen = $rutaDestino;
        } else {
            echo "Error al subir la imagen.";
        }
    }

    // Consulta para insertar el producto en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssiss", $nombre, $descripcion, $precio, $stock, $imagen);

    if ($stmt->execute()) {
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto: " . $stmt->error;
    }
    
    // Cerrar el statement
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
?>
