<?php
// Iniciar sesión para obtener datos del usuario logueado
session_start();
// Configuración de la base de datos
$host = 'localhost'; // Cambia esto según tu servidor
$db = 'gym_plataforma'; // Cambia esto al nombre de tu base de datos
$user = 'root'; // Cambia esto al usuario de tu base de datos
$password = ''; // Cambia esto a la contraseña de tu base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar programas registrados
$nombre_usuario = 'usuario_ejemplo'; // Cambia esto dinámicamente según el usuario logueado
$sql = "SELECT programa, nombre_usuario FROM registro_programas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Crear arreglo de programas
$programas = [];
while ($row = $result->fetch_assoc()) {
  $programas[] = [
    'nombre' => $row['programa'],
    'imagen' => '/htmlgym/imagenes/' . $row['programa'] . '.jpg', // Construye la ruta según el nombre del programa
    'enlace' => '/htmlgym/pages/programas/detalle_programa.php',
];
}  

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programas de Entrenamiento</title>
  <style>
body {
  font-family: 'Arial', sans-serif;
  background-color: #00010E;
margin: 0;
  padding: 0;
  color: white;
}
.contador {
  top: -10px;
  right: -10px;
  background-color: rgba(255, 0, 0, 0.7); /* Fondo del contador */
  color: white;
  border-radius: 50%;
  padding: 5px 5px;
  font-size: 14px;
}

.carrito-flotante {
  position: fixed;
  right: 0;
  top: 100px;
  width: 300px;
  background-color: #fff; /* Fondo del carrito */
  box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  z-index: 1000;
  display: block; /* Asegúrate de que esté visible */
}

.carrito-flotante h2 {
  text-align: center;
  padding: 10px;
  background-color: #000; /* Fondo del título del carrito */
  color: white;
  margin: 0;
  border-radius: 5px 5px 0 0;
}

.carrito-item {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #ddd;
  color: #000; /* Color del texto del item del carrito */
}

.total {
  font-size: 20px;
  font-weight: bold;
  text-align: right;
  padding: 10px;
}

  
  main {
    padding: 2rem;
    text-align: center;
    padding-bottom: 20px;
  }
  
  h1 {
    color: #ffffff;
    font-size: 1.8rem;
    text-align: center; /* Centra todos los h2 */
    margin-bottom: 20px;
  }
  
  p {
    color: #cccccc;
    margin-bottom: 1.5rem;
    text-align: center; /* Centra los párrafos */
  }
  
  /* Estilos del carrusel */
  .carousel {
    display: flex;
    justify-content: center; /* Centra el carrusel horizontalmente */
    align-items: center;
    gap: 1rem;
    margin: 0 auto;
  }
  
  .carousel-container {
    display: flex;
    justify-content: center;
    overflow-x: auto;
    gap: 1rem;
  }
  
  .card {
    min-width: 400px;
    background-color: #1a1a1a;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  }
  
  .card img {
    width: 100%;
    height: auto;
    display: block;
  }
  
  .card .info {
    padding: 2rem;
    text-align: center;
  }
  
  .card .info span {
    display: block;
    color: #868686;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  
  .card .info p {
    color: #ffffff;
    font-size: 1.0rem;
  }
  
  .carousel-btn {
    background-color: transparent;
    color: #ffffff;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    transition: color 0.3s;
  }
  
  .carousel-btn:hover {
    color: #666666;
  }
  
  /* Responsividad */
  @media (max-width: 768px) {
    .card {
      min-width: 150px;
    }
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
    border-top: 0.1px solid #ffffff5e;
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

  /* Botones */
  .btn 
    {
  display: inline-block;
  padding: 10px 20px;
  background: #00043d;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #0f1041, #010036);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0f1041, #010036); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  color: #ffffff; /* Color del texto del botón */
  font-weight: bold;
  border-radius: 5px;
  text-decoration: none;
  position: relative; /* Necesario para que el texto esté por encima del pseudo-elemento */
  z-index: 2;
}
  
  /* Programas */
  .programas {
    padding: 40px 300px;
  }
  
  .programas h3 {
    text-align: center; 
  }
  
  .programas-cards {
    display: flex;
    justify-content: center;
    gap: 40px;
  }
  
  .card {
    position: relative;
    width: 200px;
    overflow: hidden;
    border-radius: 10px;
    justify-content: center;
  }
  
  .card img {
    width: 100%;
    display: block;
  }
  
  .card .overlay {
    position: absolute;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    width: 100%;
    padding: 0px;
    text-align: center;
  }
  
  .card h3 {
    font-size: 1rem;
    margin-bottom: 10px;
  }
  footer {
  text-align: center;
  padding: 20px;
  margin-top: 20px;
  background-color: rgba(0, 0, 0, 0); 
  border-top: 0.1px solid #ffffff5e;
}

footer p {
  font-size: 0.9em;
  color: #ffffff; /* Color del texto del footer */
}
/* Hero Section */
.hero {
  position: relative; /* Necesario para posicionar el pseudo-elemento */
  background-size: cover;
  background-position: auto;
  margin-left: auto;
  padding: 100px 40px;
  text-align: left;
  overflow: hidden
}


  </style>
</head>
<body>
<header>
  <h2>MUSCLEGYM</h2>
  <nav>
    <a href="/htmlgym/pages/inicio/dashboard.html">Inicio</a>
    <a href="/htmlgym/pages/acerca_de/acerca.html">Acerca de</a>
    <a href="/htmlgym/pages/programas/programas1.php">Programas</a>
    <a href="/htmlgym/pages/tienda/tienda.html">Tienda</a>
    <a href="/htmlgym/pages/membrecia/membresia.html">Membresía</a>
    <a href="/htmlgym/pages/perfil/perfil1.php">Perfil</a>
    <a href="/htmlgym/pages/inicio/acceso.html">Acceso</a>
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
<header class="hero">
 <!-- Programas de entrenamiento -->
 <section class="programas">
  <h1>Programas de entrenamiento registrados</h1>
  <p>
  </p>
  <div class="programas-cards">
<?php
      if (count($programas) > 0) {
        foreach ($programas as $programa) {
          echo '<div class="card">';
          echo '<img src="' . $programa['imagen'] . '" alt="' . $programa['nombre'] . '">';
          echo '<div class="overlay">';
          echo '<h3>' . $programa['nombre'] . '</h3>';
          echo '<a class="btn" href="' . $programa['enlace'] . '?programa=' . urlencode($programa['nombre']) . '">Ver detalles</a>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p>No hay programas registrados actualmente.</p>';
      }
    ?>
  </div>
</section>

</header>
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

<footer>
  <p>© 2024 Gym Plataforma. Todos los derechos reservados.</p>
</footer>
</body>
</html>
