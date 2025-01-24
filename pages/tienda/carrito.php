<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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
.container {
    max-width: 700px;
    margin: 0 150px;
    padding: 20px;
    padding-left: 0;
}

.productos {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.producto {
    width: 30%;
    padding: 10px;
    margin: 10px;
    background-color: rgba(65, 65, 65, 0.5);
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

.producto img {
    max-width: 100%;
    border-radius: 5px;
}


.carrito-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(45, 45, 45, 0.7);
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.carrito-item div {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.carrito-item img {
    width: 100px; /* Ajusta el tamaño de la imagen */
    margin-right: 15px;
    border-radius: 5px;
    margin-right: 50px;
}

.carrito-item h4, 
.carrito-item p {
    margin: 0;
    margin-right: 30px;
}

.carrito-item .btn-cantidad {
    margin: 0 5px;
    padding: 5px 10px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    margin-right: 20px;
}

.carrito-item .btn-aumentar {
    background-color: #007bff;
    color: white;
    margin-right: 10px;
}

.carrito-item .btn-disminuir {
    background-color: #ffc107;
    color: black;
    margin-right: 10px;
}

.total {
    font-size: 1.5em;
    margin-top: 50px;
    text-align: right;
    margin-left: 50px;
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

        .carrito-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .btn-carrito {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 80px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-vaciar {
            background-color: #dc3545;
            padding: 10px 80px;
        }

        .btn-cantidad {
            margin: 0 5px;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            margin-right: 20px;
        }

        .btn-aumentar {
            background-color: #007bff;
            color: white;
            margin-bottom: 10px;
        }

        .btn-disminuir {
            background-color: #ffc107;
            color: black;
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
    <a href="/htmlgym/pages/index/login.html">Acceso</a>
  <a class="carrito-icono">
    <a href="/htmlgym/pages/tienda/carrito.php" id="carritoMenu">
      🛒 
      <span id="contadorCarrito" class="contador">0</span>
    </a>
  </a>
  <a href="/htmlgym/pages/entrenador/index.php">Chat con entrenador</a>
  <a href="/htmlgym/pages/entrenador/chat.php">Entrenador</a>
  <a href="/htmlgym/pages/tienda/formulario_agregar_producto.html">agregar producto</a>
</nav>   
</header>

<!-- Mostrar productos y Carrito en dos secciones -->
<div class="container" style="display: flex; justify-content: space-between; padding: 20px;">

    <!-- Sección de productos (izquierda) -->
    <section class="productos-section" style="width: 80%; padding-right: 80px; margin-right: 10px; margin-top: 10%">
        <h2>Carrito de Compras</h2>
        <div id="productosCarrito"></div>
    </section>

    <section class="carrito-section" style="width: 80%; padding: 5px 10px; background-color: rgba(45, 45, 45, 0.7); border-radius: 10px; margin-left: 5px; margin-bottom: 20%; margin-top: 10%; display: flex; flex-direction: column; justify-content: flex-start; margin-right: 10px;">
    <!-- Total del carrito -->
    <div id="totalCarrito" class="total" style="display: flex; justify-content: flex-start; align-items: center; margin-bottom: 20px; width: 100%;">
        <!-- Aquí puedes agregar el total del carrito -->
    </div>

    <!-- Botones -->
    <div class="carrito-buttons" style="display: center; flex-direction: column; gap: 10px; align-items: flex-start; width: 100%; padding: 10px 75px; margin: 10px 0px">
        <button class="btn-carrito btn-vaciar" onclick="vaciarCarrito()" style="text-align: left; padding: 10px 70px; width: 70%;">Vaciar el Carrito</button>
        <button class="btn-carrito" onclick="comprarCarrito()" style="text-align: center; padding: 10px 70px; width: 70%;">Comprar todo el carrito</button>
    </div>
</section>

</div>


    <footer>
        <p>&copy; 2025 MUSCLEGYM. Todos los derechos reservados.</p>
    </footer>

    <script>
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
        function mostrarCarrito() {
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const productosCarrito = document.getElementById('productosCarrito');
            const totalCarrito = document.getElementById('totalCarrito');

            productosCarrito.innerHTML = '';
            let total = 0;

            carrito.forEach((producto, index) => {
                total += producto.precio * producto.cantidad;

                const div = document.createElement('div');
                div.className = 'carrito-item';
                div.innerHTML = `
                    <div>
                        <img src="${producto.imagen}" alt="${producto.nombre}" style="width: 100px; height: auto; border-radius: 5px;">
                        <h4>${producto.nombre}</h4>
                        <p>Precio: $${producto.precio}</p>
                        <p>Cantidad: ${producto.cantidad}</p>
                        <button class="btn-cantidad btn-aumentar" onclick="aumentarCantidad(${index})">+</button>
                        <button class="btn-cantidad btn-disminuir" onclick="disminuirCantidad(${index})">-</button>
                    </div>
                    <p>Total: $${(producto.precio * producto.cantidad).toFixed(2)}</p>
                `;
                productosCarrito.appendChild(div);
            });

            totalCarrito.innerHTML = `Total del Carrito: $${total.toFixed(2)}`;
        }

        function aumentarCantidad(index) {
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            carrito[index].cantidad++;
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarCarrito();
        }

        function disminuirCantidad(index) {
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            if (carrito[index].cantidad > 1) {
                carrito[index].cantidad--;
            } else {
                carrito.splice(index, 1);
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarCarrito();
        }

        function vaciarCarrito() {
            localStorage.removeItem('carrito');
            mostrarCarrito();
        }

        function comprarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    if (carrito.length === 0) {
        alert('El carrito está vacío.');
        return;
    }
    // Guarda los datos del carrito en localStorage antes de redirigir
    localStorage.setItem('carritoCompra', JSON.stringify(carrito));
    // Redirige a la página de compra
    window.location.href = 'compra.html';
}

        window.onload = mostrarCarrito;
    </script>
</body>
</html>
