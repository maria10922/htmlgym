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
$sql_usuario = "SELECT nombre_usuario, email FROM usuario WHERE nombre_usuario = ?";
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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar compra</title>
    <style>
.contador {
  top: -10px;
  right: -10px;
  background-color: rgba(255, 0, 0, 0.7); /* Fondo del contador */
  color: white;
  border-radius: 50%;
  padding: 5px 5px;
  font-size: 14px;
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
        .carrito {
    width: 280px;
    background-color: #2e2e2e00;
    padding: 47px;
    border-radius: 10px;
    padding: 10px 90px;
    margin-top: 10px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.158);
}
.titulo{
    display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #03030300;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0);
}


        .contenedor {
    gap: 20px; /* Espaciado entre las secciones */
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.158);
    width: 80%;
    margin: 50px 50px;
    padding: 20px;
  }
  .section, .banco {
    flex: 1; /* Hace que ambas secciones ocupen el mismo espacio */
    padding: 30px;
    background-color: #2e2e2e00;
    color: white;
    border-radius: 0px;
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0);
  }
  .producto {
            display: flex;
            margin-bottom: 20px;
        }
        .producto-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .producto-info {
            margin-left: 15px;
        }
        .producto-info h3 {
            font-size: 18px;
            margin: 0;
        }
        .precio {
            color: #00bfae;
            font-size: 16px;
        }
        .descripcion {
            font-size: 14px;
            color: #ffffff;
        }
        .cantidad {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .action-btn{
            background-color: #080030;
            color: white;
            padding: 10px;
            width: 30%;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            margin-left: 350px;
        }
        .subtotal {
            font-size: 18px;
            margin-top: 20px;
        }
        .subtotal span {
            color: #00bfae;
        }
        .btn-pagar {
            background-color: #09002b;
            color: white;
            padding: 10px;
            width: 60%;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn-pagar:hover {
            background-color: #090030;
        }

.container {
    width: 80%;
    margin: 50px auto;
    background-color: #2e2e2e00;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.158);
}

.detalle-envio h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

.direccion, .envios {
    margin-bottom: 20px;
}

.direccion p, .envios p {
    font-size: 16px;
    margin-bottom: 5px;
}

.editar, .modificar {
    font-size: 14px;
    color: #2f00ff;
    text-decoration: none;
}

.editar:hover, .modificar:hover {
    text-decoration: underline;
}




.info p {
    font-size: 14px;
    color: #ffffff;
}

.info strong {
    font-size: 16px;
    color: #ffffff;
}


/* Contenedor principal */
.container {
    width: 80%;
    margin: 50px auto;
    background-color: #ffffff00;
    padding: 20px;
    border-radius: 8px;
}

/* Estilos para la sección de detalles del pago */
.detalle-pago {
    padding: 20px;
    border-radius: 8px;
    margin-top: 30px;
    background-color:rgba(244, 244, 244, 0); /* Puedes agregar un color de fondo para distinguirlo */
}

/* Párrafos dentro de detalle-pago */
.detalle-pago p {
    display: block; /* Se asegura que cada párrafo esté en una nueva línea */
    margin-bottom: 10px; /* Agrega un pequeño margen entre los párrafos */
    font-size: 16px; /* Puedes ajustar el tamaño de fuente si es necesario */
    color:rgb(168, 168, 168); /* Color de texto */
    font-size: 14px;
}

/* Títulos h3 dentro de detalle-pago */
.detalle-pago h3 {
    display: block; /* El título h3 se apila por defecto */
    margin-bottom: 10px; /* Espacio debajo del título */
    margin-left: 0px; /* Remueve el margen izquierdo si no es necesario */
    font-size: 19px; /* Puedes ajustar el tamaño de fuente del h3 si es necesario */
    font-weight: bold; /* Asegura que el h3 sea destacado */
    color: #ffffff; /* Color de texto para el h3 */
}


.pago-banco,
.pago-titular {
    display: flex;
    align-items: center;
    gap: 15px; /* Espaciado entre elementos */
    margin-bottom: 20px;
    padding: 15px;
    background-color:rgba(26, 26, 26, 0); /* Fondo ligeramente más claro */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
}

.pago-banco .logo img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-right: 20px;
}

.pago-titular p {
    font-size: 16px;
    margin: 5px 0;
}

.enlace-modificar {
    display: inline-block;
    margin-top: 20px;
    font-size: 14px;
    color: #00aaff; /* Azul para destacar */
    text-decoration: none;
}

.enlace-modificar:hover {
    text-decoration: underline;
}


        .enlace-modificar:hover {
            text-decoration: underline;
        }
        label {
      text-align: left;
    }
    input, textarea, select {
      padding: 10px;
      border-radius: 5px;
      border: none;
      width: 20%;
      margin-top: 20px;
      margin-bottom: 20px;
    }
    input[type="file"] {
      background-color: #ffffff;
      color: #000000;
    }
    .carrito{
        width: 80%;
    margin: 50px auto;
    background-color: #2e2e2e00;
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
 
  <div class="container">
<section class="titulo">
        <h2>Revisa y confirma tu compra</h2>
</section>

    <section class="detalle-envio">
            <div class="carrito">
              <h2>Productos de la compra</h2>
              <div id="productosCompra"></div>
          
              <div>
                  <h2>Resumen de la compra</h2>
              </div>
              <div id="cantidadproductos">
              </div>
              <div id="total" class="total">
                Pagas: $0.00
              </div>
            </div>

</div>
<div class="container">
    <section class="detalle-pago">
        <h2>Detalle del pago</h2>

        <div class="pago-banco">
            <div class="pago-banco">
               <h3><div id="bancoSeleccionado">No se seleccionó ningún banco.</div></h3>
                
                <p>No demores en pagar, solo podemos reservarte stock cuando el pago se acredite.</p>
                <a href="pago.html" class="enlace-modificar">Modificar</a>
            </div>
        </div>
        <h2>Informacion del usuario</h2>
        <div class="pago-titular">
            
    <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($usuarioDatos['nombre_usuario']); ?>" required><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuarioDatos['email']); ?>" required><br>

            <a href="/htmlgym/pages/perfil/perfil1.php" class="enlace-modificar">Modificar datos</a>
        </div>
    </section>
    <button class="action-btn" onclick="vaciarCarrito()">Listo</button>

</div>
  </div>

    <!-- Footer -->
    <footer>
      <p>© 2024 MUSCLEGYM. Todos los derechos reservados.</p>
    </footer>
  
    <script>
   // Obtener parámetros de la URL y mostrar el banco seleccionado
   const urlParams = new URLSearchParams(window.location.search);
        const banco = urlParams.get('banco');
        if (banco) {
            document.getElementById('bancoSeleccionado').textContent = `Banco seleccionado: ${banco}`;
        }
        function vaciarCarrito() {
    // Limpiar los datos del carrito almacenados en localStorage (si los usas)
    localStorage.removeItem('carrito');

    // También puedes limpiar la sesión si el carrito está almacenado allí
    sessionStorage.removeItem('carrito');

    // Redirigir al usuario al carrito
    window.location.href = 'carrito.php';
}

      // Cargar los productos del carrito desde el localStorage
      document.addEventListener('DOMContentLoaded', () => {
          const carrito = JSON.parse(localStorage.getItem('carritoCompra')) || [];
  
          const productosCompraDiv = document.getElementById('productosCompra');
          const cantidadProductos = document.getElementById('cantidadproductos');
          const totalDiv = document.getElementById('total');
          const contadorCarrito = document.getElementById('contadorCarrito');
  
          let totalCompra = 0;
          let cantidadTotal = 0;
  
          if (carrito.length > 0) {
              carrito.forEach(producto => {
                  productosCompraDiv.innerHTML += `
                      <div class="producto">
                          <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-img">
                          <div class="producto-info">
                              <h3>${producto.nombre}</h3>
                              <p class="precio">$${(producto.precio * producto.cantidad).toFixed(2)}</p>
                              <p class="descripcion">Cantidad: ${producto.cantidad}</p>
                          </div>
                      </div>
                  `;
                  totalCompra += producto.precio * producto.cantidad;
                  cantidadTotal += producto.cantidad;
              });
              cantidadProductos.innerHTML = `Cantidad de productos (${cantidadTotal}): $${totalCompra.toFixed(2)}`;
              totalDiv.innerHTML = `Pagas: $${totalCompra.toFixed(2)}`;
              contadorCarrito.textContent = carrito.length; // Actualiza el contador de productos
          } else {
              productosCompraDiv.innerHTML = '<p>No hay productos en la compra.</p>';
              cantidadProductos.innerHTML = 'Cantidad de productos (0): $0.00';
              totalDiv.innerHTML = 'Pagas: $0.00';
              contadorCarrito.textContent = '0';
          }
      });
    </script>
  </body>
  </html>
  