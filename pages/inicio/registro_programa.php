<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'gym_plataforma';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar si los datos necesarios están presentes
        if (isset($_POST['nombre_usuario']) && isset($_POST['programa'])) {
            $nombre_usuario = $_POST['nombre_usuario']; // Nombre de usuario único
            $programa = $_POST['programa']; // Nombre del programa

            // Insertar en la tabla registro_programas
            $sql = "INSERT INTO registro_programas (nombre_usuario, programa) 
                    VALUES (:nombre_usuario, :programa)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre_usuario' => $nombre_usuario,
                ':programa' => $programa,
            ]);

            echo "Programa registrado exitosamente.";
        } else {
            echo "Faltan datos necesarios.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
