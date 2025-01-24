<?php
$host = 'localhost';
$db = 'gym_plataforma';
$user = 'root';
$pass = '';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo de la solicitud JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Verificar si 'ids' está presente en el cuerpo de la solicitud
    $ids = isset($input['ids']) ? $input['ids'] : [];

    if (!empty($ids)) {
        try {
            // Establecer la conexión a la base de datos
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Convertir los IDs a enteros y eliminar duplicados
            $ids = array_map('intval', array_unique($ids));

            // Crear marcadores de posición para la consulta
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Preparar la consulta SQL
            $sql = "DELETE FROM messages WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($sql);

            // Ejecutar la consulta con los valores de $ids
            $stmt->execute($ids);

            // Verificar si se eliminaron mensajes
            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Messages deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No messages were deleted.']);
            }
        } catch (PDOException $e) {
            // Manejo de errores con un mensaje claro
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // Error si no se proporcionaron IDs
        echo json_encode(['status' => 'error', 'message' => 'No IDs provided.']);
    }
} else {
    // Error si no se usa el método POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
