<?php
session_start();

$host = 'localhost';
$db = 'gym_plataforma';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre_programa = isset($_GET['programa']) ? $_GET['programa'] : '';

if ($nombre_programa) {
    // Obtener detalles del programa
    $sql = "SELECT * FROM detalles_programas WHERE programa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_programa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $programa = $result->fetch_assoc();
    } else {
        $programa = null;
    }
    $stmt->close();
} else {
    $programa = null;
}

// Obtener ejercicios relacionados con el programa
$ejercicios = [];
if ($programa) {
    $sql = "SELECT * FROM ejercicios WHERE programa_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $programa['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ejercicios[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Programa</title>
    <style>
      /* Footer */
footer {
  text-align: center;
  padding: 10px;
  margin-top: 20px;
  background-color: #00010E;
  border-top: 0.1px solid #ffffff5e;
}

footer p {
  font-size: 0.9em;
  color: #ffffff; /* Color del texto del footer */
}

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

        h2 {
            text-align: center;
            font-size: 2rem;
            margin: 20px 0;
        }

        .program-section {
            text-align: center;
            padding: 20px;
        }

        .program-section h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .program-section p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .carousel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 40px;
        }

        .carousel {
            display: flex;
            overflow: hidden;
            width: 80%;
        }

        .card {
            min-width: 300px;
            margin: 10px;
            background-color: #1a1a33; /* Color de fondo de las tarjetas */
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Sombra de las tarjetas */
        }

        .card img {
            width: 100%;
            border-radius: 10px 10px 0 0; /* Bordes redondeados en la parte superior */
        }

        .card .details {
            padding: 15px;
        }

        .card .details p {
            margin: 5px 0;
        }

        .badge {
            background-color: #009966; /* Color de fondo de la etiqueta */
            color: #fff; /* Color del texto de la etiqueta */
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #fff; /* Color de fondo de las flechas */
            color: #000; /* Color del texto de las flechas */
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .arrow:hover {
            background-color: #ccc; /* Color de fondo al pasar el mouse */
        }

        .arrow.left {
            left: 10px;
        }

        .arrow.right {
            right: 10px;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .card {
                min-width: 150px; /* Ajusta el ancho mínimo de las tarjetas en pantallas pequeñas */
            }
        }
    </style>
</head>
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
<body>
    <?php if ($programa): ?>
        <h2><?php echo htmlspecialchars($programa['programa']); ?></h2>
        
        <div class="program-section">
            <h3><?php echo htmlspecialchars($programa['descripcion']); ?></h3>
        </div>

        <div class="carousel-container">
            <button class="arrow left" onclick="moveCarousel(-1, 0)">&#10094;</button>
            <div class="carousel" id="carousel1">
                <!-- Aquí puedes agregar dinámicamente los ejercicios -->
                <?php foreach ($ejercicios as $ejercicio): ?>
                    <div class="card">
                    <a href="ejercicio.php?nombre=<?php echo urlencode($ejercicio['nombre']); ?>&descripcion=<?php echo urlencode($ejercicio['descripcion']); ?>&imagen=<?php echo urlencode($ejercicio['imagen']); ?>&series=<?php echo urlencode($ejercicio['series']); ?>">
    <img src="<?php echo htmlspecialchars($ejercicio['imagen']); ?>" alt="<?php echo htmlspecialchars($ejercicio['nombre']); ?>" width="300" height="200">
</a>              <div class="details">
                            <p><strong><?php echo htmlspecialchars($ejercicio['nombre']); ?></strong></p>
                            <p><?php echo htmlspecialchars($ejercicio['descripcion']); ?></p>
                            <p><span class="badge"><?php echo htmlspecialchars($ejercicio['series']); ?></span></p> <!-- Muestra la serie correspondiente -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="arrow right" onclick="moveCarousel(1, 0)">&#10095;</button>
        </div>

    <?php else: ?>
        <p>Programa no encontrado.</p>
    <?php endif; ?>
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
        // Inicializa los carruseles
        const carousels = [
            document.getElementById('carousel1'),
            // Agrega más carruseles si es necesario
        ];

        const scrollAmounts = [0]; // Para rastrear el desplazamiento de cada carrusel

        function moveCarousel(direction, carouselIndex) {
            const scrollStep = 320; // Ancho de cada tarjeta + márgenes
            scrollAmounts[carouselIndex] += direction * scrollStep;

            // Asegúrate de que no se desplace más allá de los límites
            if (scrollAmounts[carouselIndex] < 0) {
                scrollAmounts[carouselIndex] = 0; // No permitir desplazamiento hacia la izquierda más allá del inicio
            }

            const maxScroll = carousels[carouselIndex].scrollWidth - carousels[carouselIndex].clientWidth;
            if (scrollAmounts[carouselIndex] > maxScroll) {
                scrollAmounts[carouselIndex] = maxScroll; // No permitir desplazamiento hacia la derecha más allá del final
            }

            carousels[carouselIndex].scrollTo({
                left: scrollAmounts[carouselIndex],
                behavior: 'smooth' // Desplazamiento suave
            });
        }
    </script>
    
<footer>
  <p>© 2024 Gym Plataforma. Todos los derechos reservados.</p>
</footer>
</body>
</html>