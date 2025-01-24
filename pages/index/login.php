<?php
// Iniciar la sesión
session_start();
$_SESSION['nombre_usuario'] = $nombre_usuario;

// Datos de conexión
$servername = "localhost"; // Servidor de la base de datos
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // XAMPP por defecto no tiene contraseña
$dbname = "gym_plataforma"; // Nombre de la base de datos

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el modo de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];

        // Verificar las credenciales usando nombre_usuario
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nombre_usuario' => $nombre_usuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['usuario'] = $usuario;

            // Redirigir al perfil
            header('Location: /htmlgym/pages/inicio/dashboard.html');
            exit;
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    }
} catch (PDOException $e) {
    // Manejar errores de conexión
    echo "Error al conectar con la base de datos: " . $e->getMessage();
}
?>
