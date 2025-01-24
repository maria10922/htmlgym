<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../../login.php');
    exit();
}

$usuario = $_SESSION['usuario'];  // Usuario autenticado

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root"; // Cambia estos valores según tu configuración
$password = "";
$dbname = "gym_plataforma";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Ajustar la consulta para obtener los datos del usuario
$sql_usuario = "SELECT id_usuario, nombre_usuario, email, peso, estatura, foto_perfil FROM usuario WHERE nombre_usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $usuario['nombre_usuario']);  // Usamos el nombre de usuario de la sesión
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();

// Verificar si se obtuvo el usuario
if ($result_usuario->num_rows > 0) {
    $usuarioDatos = $result_usuario->fetch_assoc();  // Datos del usuario
} else {
    echo "No se encontró el usuario.";
    exit();
}

// Ajustar la consulta para obtener la membresía del usuario
$sql_membresia = "SELECT nombre, email, telefono, plan, fecha_registro FROM membresias WHERE email = ?";
$stmt_membresia = $conn->prepare($sql_membresia);
$stmt_membresia->bind_param("s", $usuarioDatos['email']);  // Usamos el email del usuario
$stmt_membresia->execute();
$result_membresia = $stmt_membresia->get_result();

// Verificar si se obtuvo la membresía
if ($result_membresia->num_rows > 0) {
    $membresiaDatos = $result_membresia->fetch_assoc();  // Datos de la membresía
} else {
    echo "No se encontró la membresía asociada al usuario.";
    exit();
}

$stmt_usuario->close();
$stmt_membresia->close();
$conn->close();

// Procesar el formulario cuando se sube una nueva foto de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_perfil'])) {
    // Definir el directorio donde se guardarán las fotos
    $directorioDestino = '/htmlgym/pages/index/uploads'; // Asegúrate de que el directorio exista

    // Obtener la extensión del archivo
    $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
    
    // Generar un nombre único para la imagen
    $nombreArchivo = uniqid() . '.' . $extension;

    // Mover el archivo al directorio destino
    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $directorioDestino . $nombreArchivo)) {
        // Guardar la ruta de la foto en la sesión (o en la base de datos, si es necesario)
        $_SESSION['usuario']['foto_perfil'] = $directorioDestino . $nombreArchivo;
    } else {
        echo "Error al subir la imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil del Usuario</title>
  <script>
  // Actualizar el contador del carrito
  function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    document.getElementById('contadorCarrito').textContent = carrito.reduce(
      (total, item) => total + item.cantidad,
      0
    );
  }
          // Cargar carrito desde localStorage al cargar la página
          document.addEventListener('DOMContentLoaded', () => {
      actualizarContadorCarrito();
        })
  </script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #00010E;
      margin: 0;
      padding: 0;
      color: white;
    }
    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: rgba(0, 0, 0, 0);
      position: relative;
      z-index: 2;
      border-bottom: 0.1px solid #ffffff5e;
    }
    header nav a {
      color: #ffffff;
      margin-left: 15px;
      text-decoration: none;
      font-weight: bold;
    }
    a {
      text-decoration: none;
    }
    main {
      padding: 20px;
      text-align: center;
    }
    main h2 {
      font-size: 2em;
      color: #ffffff;
    }
    form {
      max-width: 500px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    label {
      text-align: left;
    }
    input, textarea, select {
      padding: 10px;
      border-radius: 5px;
      border: none;
      width: 100%;
    }
    input[type="file"] {
      background-color: #ffffff;
      color: #000000;
    }
    button {
      display: inline-block;
      padding: 10px 20px;
      background: #00043d;
      color: #ffffff;
      font-weight: bold;
      border-radius: 5px;
      text-decoration: none;
      position: relative;
      z-index: 2;
    }
    button:hover {
      background-color: rgb(9, 0, 88);
    }
    footer {
      text-align: center;
      padding: 10px;
      margin-top: 20px;
      background-color: rgba(0, 0, 0, 0);
      border-top: 0.1px solid #ffffff5e;
    }
    footer p {
      font-size: 0.9em;
      color: #ffffff;
    }
    .contador {
      top: -10px;
      right: -10px;
      background-color: rgba(255, 0, 0, 0.7);
      color: white;
      border-radius: 50%;
      padding: 5px 5px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <!-- Header de navegación -->
  <header>
  <h2>MUSCLEGYM</h2>
  <nav>
    <a href="/htmlgym/pages/inicio/dashboard.html">Inicio</a>
    <a href="/htmlgym/pages/acerca_de/acerca.html">Acerca de</a>
    <a href="/htmlgym/pages/programas/programas.php">Programas</a>
    <a href="/htmlgym/pages/tienda/tienda.html">Tienda</a>
    <a href="/htmlgym/pages/membrecia/membresia.html">Membresía</a>
    <a href="/htmlgym/pages/perfil/perfil1.php">Perfil</a>
    <a href="/htmlgym/pages/index/login.html">Acceso</a>
  <a class="carrito-icono">
    <a href="/htmlgym/pages/tienda/carrito.html" id="carritoMenu">
      🛒 
      <span id="contadorCarrito" class="contador">0</span>
    </a>
  </a>
  <a href="/htmlgym/pages/entrenador/index.php">Chat con entrenador</a>
  <a href="/htmlgym/pages/entrenador/chat.php">Entrenador</a>
</nav>   
</header>

  <main>
    <h2>Perfil del Usuario</h2>

    <img src="<?php echo '/htmlgym/pages/index/' . htmlspecialchars($usuarioDatos['foto_perfil']); ?>" alt="Foto de perfil" width="100" height="100"><br>

    <form action="perfil.php" method="POST" enctype="multipart/form-data">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($usuarioDatos['nombre_usuario']); ?>" required><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuarioDatos['email']); ?>" required><br>

        <label for="peso">Peso (kg):</label>
        <input type="number" id="peso" name="peso" value="<?php echo htmlspecialchars($usuarioDatos['peso']); ?>" required><br>

        <label for="estatura">Estatura (cm):</label>
        <input type="number" id="estatura" name="estatura" value="<?php echo htmlspecialchars($usuarioDatos['estatura']); ?>" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <h3>Datos de Membresía</h3>
<form>
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" value="<?php echo htmlspecialchars($membresiaDatos['telefono']); ?>" readonly>

    <label for="plan">Plan:</label>
    <input type="text" id="plan" value="<?php echo htmlspecialchars($membresiaDatos['plan']); ?>" readonly>

    <label for="fecha_registro">Fecha de Registro:</label>
    <input type="text" id="fecha_registro" value="<?php echo htmlspecialchars($membresiaDatos['fecha_registro']); ?>" readonly>
</form>

  </main>

  <footer>
    <p>© 2024 Gym Plataforma. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
