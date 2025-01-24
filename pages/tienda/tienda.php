<?php
// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$nombreBD = 'gym_plataforma';
$conexion = new mysqli($host, $usuario, $clave, $nombreBD);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos Fitness</title>
  
  <style>
    /* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #00010E;
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


/* Estilos para la sección hero */
.hero {
    background-color:rgba(15, 0, 56, 0.29);
    color: white;
    padding: 60px 20px;
    display: flex;
    flex-direction: column;  
    justify-content: center; 
    align-items: center;  
    text-align: center; 
}

.hero h1 {
    font-size: 2.5rem;
    margin: 0;
    margin-bottom: 15px;
}

.hero p {
    font-size: 1.2rem;
    margin: 0;  
}


/* Estilos para la galería de productos */
.productos {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
}

.producto {
    background-color:rgb(0, 1, 14);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.22);
    width: 280px;
    margin: 10px;
    padding: 15px;
    text-align: center;
}

.producto img {
    max-width: 60%;
    border-radius: 8px;
}

.producto h3 {
    font-size: 1.3rem;
    margin: 10px 0;
}

.producto p {
    font-size: 1rem;
    color: white;
    text-align: left;
    margin: 13px;
}

.producto-precio {
    font-size: 1.2rem;
    font-weight: bold;
    margin: 10px 0;
}

.producto-stock {
    font-size: 1rem;
    color: #27ae60;
}

.producto-comprar {
    background-color:rgb(8, 0, 53);
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

.producto-comprar:hover {
    background-color: #c0392b;
}

/* Footer */
footer {
  text-align: center;
  padding: 10px;
  margin-top: 20px;
  background-color: rgba(0, 0, 0, 0); 
  border-top: 0.1px solid #ffffff5e;
}

footer p {
  font-size: 0.9em;
  color: #ffffff; /* Color del texto del footer */
}

/* Estilos de responsividad */
@media (max-width: 768px) {
    .productos {
        flex-direction: column;
        align-items: center;
    }

    .producto {
        width: 90%;
    }
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
      <a href="/htmlgym/pages/tienda/tienda.php">Tienda</a>
      <a href="/htmlgym/pages/membrecia/membresia.html">Membresía</a>
      <a href="/htmlgym/pages/perfil/perfil1.php">Perfil</a>
      <a href="/htmlgym/pages/inicio/acceso.html">Acceso</a>
      <a class="carrito-icono">
        <a href="/htmlgym/pages/tienda/carrito.php" id="carritoMenu">
          🛒 
          <span id="contadorCarrito" class="contador">0</span>
        </a>
      </a>
      <a href="/htmlgym/pages/entrenador/index.php">Chat con entrenador</a>
      <a href="/htmlgym/pages/entrenador/chat.php">Entrenador</a>
    </nav>   
  </header>

  <header class="hero">
    <h1>Explora nuestros productos Fitness</h1>

    <p>Encuentra los mejores productos para tu entrenamiento y salud.</p>
  </header>
  
  <div class="productos">
    <?php
      // Mostrar productos desde la base de datos
      if ($resultado->num_rows > 0) {
          while ($producto = $resultado->fetch_assoc()) {
              // Variables del producto
              $nombre = $producto['nombre'];
              $descripcion = $producto['descripcion'];
              $precio = $producto['precio'];
              $stock = $producto['stock'];
              $imagen = $producto['imagen']; // Ya contiene la ruta relativa desde la base de datos


              // Mostrar el producto en HTML
              echo "<div class='producto'>";
              echo "<img src='$imagen' alt='$nombre' class='producto-imagen'>";
              echo "<h3 class='producto-nombre'>$nombre</h3>";
              echo "<p class='producto-descripcion'>$descripcion</p>";
              echo "<p class='producto-precio'>Precio: $$precio</p>";
              echo "<p class='producto-stock'>Stock: $stock</p>";
              echo "<button class='producto-comprar' onclick='agregarAlCarrito(\"$nombre\", \"$precio\", \"$imagen\", \"$descripcion\", \"$stock\")'>Agregar al carrito</button>";
              echo "</div>";
          }
      } else {
          echo "<p>No se encontraron productos.</p>";
      }

      // Cerrar la conexión
      $conexion->close();
    ?>
  </div>

  <footer>
    <p>&copy; 2025 MUSCLEGYM. Todos los derechos reservados.</p>
  </footer>

  <script>
    function agregarAlCarrito(nombre, precio, imagen, descripcion, stock) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Verificar si el producto ya está en el carrito
    let productoExistente = carrito.find(producto => producto.nombre === nombre);
    if (productoExistente) {
        // Si el producto ya existe, aumentar la cantidad
        productoExistente.cantidad += 1;
    } else {
        // Si no existe, agregarlo al carrito con una cantidad de 1
        carrito.push({ 
            nombre: nombre, 
            precio: precio, 
            imagen: imagen, // Asegúrate de que la ruta de la imagen sea correcta
            descripcion: descripcion,
            stock: stock,
            cantidad: 1 
        });
    }
    function agregarAlCarrito(nombre, precio, imagen) {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const producto = { nombre, precio, imagen, cantidad: 1 };

    const existe = carrito.find(item => item.nombre === nombre);
    if (existe) {
        existe.cantidad++;
    } else {
        carrito.push(producto);
    }

    localStorage.setItem('carrito', JSON.stringify(carrito));
    mostrarCarrito();
}

    localStorage.setItem('carrito', JSON.stringify(carrito));

    // Verificar la ruta de la imagen en el localStorage
    console.log(imagen);  // Esto debería mostrar la ruta de la imagen en la consola.

    // Actualizar el contador del carrito
    document.getElementById('contadorCarrito').textContent = carrito.length;
}

    // Actualizar el contador al cargar la página
    window.onload = function() {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        document.getElementById('contadorCarrito').textContent = carrito.length;
    };
  </script>
</body>
</html>
