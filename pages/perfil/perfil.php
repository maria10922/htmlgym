<?php
// Iniciar la sesión
session_start();

// Datos de conexión
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "gym_plataforma"; 

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../login.php'); 
    exit(); // Termina la ejecución aquí, no hay código después de este punto.
}

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Obtener datos del usuario de la sesión
$usuario = $_SESSION['usuario'];

// Obtener la membresía del usuario
$sql_membresia = "SELECT membresia.nombre FROM usuario 
                  JOIN membresia ON usuario.id_membresia = membresia.id 
                  WHERE usuario.nombre_usuario = :nombre_usuario";
$stmt_membresia = $pdo->prepare($sql_membresia);
$stmt_membresia->execute([':nombre_usuario' => $usuario['nombre_usuario']]);
$membresia = $stmt_membresia->fetch(PDO::FETCH_ASSOC);

// Procesar el formulario cuando se sube una nueva foto de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'] ?? $usuario['nombre_usuario'];
    $email = $_POST['email'] ?? $usuario['email'];
    $peso = $_POST['peso'] ?? $usuario['peso'];
    $estatura = $_POST['estatura'] ?? $usuario['estatura'];
    
    // Manejo de la foto de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $directorioDestino = '/htmlgym/pages/index/uploads'; // Directorio donde se guardan las fotos
        $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid() . '.' . $extension;
        
        // Mover la foto al directorio destino
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $directorioDestino . $nombreArchivo)) {
            $foto_perfil = $directorioDestino . $nombreArchivo;
        } else {
            $foto_perfil = $usuario['foto_perfil']; // Si no se subió una nueva foto, mantener la actual
        }
    } else {
        $foto_perfil = $usuario['foto_perfil']; // Si no se sube foto, mantener la actual
    }

    try {
        // Preparar la consulta SQL para actualizar los datos del usuario
        $sql = "UPDATE usuario 
                SET nombre_usuario = :nombre_usuario, 
                    email = :email, 
                    peso = :peso, 
                    estatura = :estatura, 
                    foto_perfil = :foto_perfil 
                WHERE nombre_usuario = :current_nombre_usuario";

        // Ejecutar la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $nombre_usuario,
            ':email' => $email,
            ':peso' => $peso,
            ':estatura' => $estatura,
            ':foto_perfil' => $foto_perfil,
            ':current_nombre_usuario' => $usuario['nombre_usuario']
        ]);

        // Actualizar la sesión con los nuevos datos
        $_SESSION['usuario'] = [
            'nombre_usuario' => $nombre_usuario,
            'email' => $email,
            'peso' => $peso,
            'estatura' => $estatura,
            'foto_perfil' => $foto_perfil // Asignar la nueva foto de perfil a la sesión
        ];

        // Redirigir al perfil
        header('Location: /htmlgym/pages/perfil/perfil1.php');
        exit(); // Detiene la ejecución aquí, evitando código posterior
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar los datos: " . $e->getMessage();
        header('Location: /htmlgym/pages/perfil/perfil1.php');
        exit(); // Detiene la ejecución aquí también
    }
}
?>