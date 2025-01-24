// Productos de ejemplo
let productos = [
    {
      id: 1,
      nombre: "Producto 1",
      precio: 10.0,
      img: "/htmlgym/pages/tienda/uploads/img.png",
    },
    {
      id: 2,
      nombre: "Producto 2",
      precio: 20.0,
      img: "/htmlgym/pages/tienda/uploads/img.png",
    },
    {
      id: 3,
      nombre: "Producto 3",
      precio: 30.0,
      img: "/htmlgym/pages/tienda/uploads/img.png",
    },
  ];
  
  // Carrito de compras
  let carrito = [];
  
  // Mostrar productos en la página
  function mostrarProductos() {
    const productosContenedor = document.getElementById("productosListados");
    productosContenedor.innerHTML = ""; // Limpiar el contenedor antes de añadir productos
    productos.forEach((producto) => {
      const productoDiv = document.createElement("div");
      productoDiv.classList.add("producto");
      productoDiv.innerHTML = `
        <img src="${producto.img}" alt="${producto.nombre}">
        <h3>${producto.nombre}</h3>
        <p>$${producto.precio.toFixed(2)}</p>
        <button class="btn" onclick="agregarAlCarrito(${producto.id})">Agregar al carrito</button>
      `;
      productosContenedor.appendChild(productoDiv);
    });
  }
  
  // Función para agregar un producto al carrito
  function agregarAlCarrito(idProducto) {
    const producto = productos.find((p) => p.id === idProducto);
    if (!producto) return;
  
    const productoExistente = carrito.find((p) => p.id === idProducto);
  
    if (productoExistente) {
      productoExistente.cantidad++;
    } else {
      carrito.push({ ...producto, cantidad: 1 });
    }
  
    actualizarCarrito();
  }
  
  // Función para actualizar la vista del carrito
  function actualizarCarrito() {
    const carritoContenido = document.getElementById("carritoContenido");
    const contadorCarrito = document.getElementById("contadorCarrito");
    const totalCarrito = document.getElementById("total");
  
    if (carrito.length === 0) {
      carritoContenido.innerHTML = '<p class="empty">El carrito está vacío.</p>';
      totalCarrito.innerText = "Total: $0.00";
      contadorCarrito.innerText = "0";
      return;
    }
  
    let total = 0;
    carritoContenido.innerHTML = ""; // Limpiar el contenido del carrito antes de actualizar
  
    carrito.forEach((producto) => {
      const itemDiv = document.createElement("div");
      itemDiv.classList.add("carrito-item");
      itemDiv.innerHTML = `
        <img src="${producto.img}" alt="${producto.nombre}" style="width: 50px; height: 50px; object-fit: cover;">
        <span>${producto.nombre}</span>
        <span>Cantidad: ${producto.cantidad}</span>
        <span>Subtotal: $${(producto.precio * producto.cantidad).toFixed(2)}</span>
      `;
      carritoContenido.appendChild(itemDiv);
      total += producto.precio * producto.cantidad;
    });
  
    totalCarrito.innerText = `Total: $${total.toFixed(2)}`;
    contadorCarrito.innerText = carrito.length.toString();
  }
  
  // Inicializar productos en la página
  document.addEventListener("DOMContentLoaded", () => {
    mostrarProductos();
    actualizarCarrito();
  });
  