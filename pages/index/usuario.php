<?php
// Datos de conexión
$servername = "localhost"; // Servidor de la base de datos
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // XAMPP por defecto no tiene contraseña
$dbname = "gym_plataforma"; // Nombre de la base de datos

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar datos del formulario
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $peso = filter_var($_POST['peso'], FILTER_VALIDATE_FLOAT);
    $estatura = filter_var($_POST['estatura'], FILTER_VALIDATE_FLOAT);
    $foto_perfil = null;

    if (!$nombre_usuario || !$email || !$password || !$peso || !$estatura) {
        die("Por favor, complete todos los campos correctamente.");
    }

    // Subir foto de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $directorio_uploads = 'uploads/';
        if (!is_dir($directorio_uploads)) {
            mkdir($directorio_uploads, 0777, true);
        }

        $nombre_archivo = basename($_FILES['foto_perfil']['name']);
        $foto_perfil = $directorio_uploads . $nombre_archivo;

        if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil)) {
            die("Error al subir la foto de perfil.");
        }
    }

    try {
        // Verificar si el nombre de usuario ya está registrado
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nombre_usuario' => $nombre_usuario]);
        $usuario_existente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario_existente) {
            die("El nombre de usuario ya está registrado.");
        }

        // Cifrar la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $sql = "INSERT INTO usuario (nombre_usuario, email, password, peso, estatura, foto_perfil) 
                VALUES (:nombre_usuario, :email, :password, :peso, :estatura, :foto_perfil)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $nombre_usuario,
            ':email' => $email,
            ':password' => $password_hash,
            ':peso' => $peso,
            ':estatura' => $estatura,
            ':foto_perfil' => $foto_perfil
        ]);

        echo "Registro exitoso!";
    } catch (PDOException $e) {
        die("Error al procesar el registro: " . $e->getMessage());
    }
}
?>
