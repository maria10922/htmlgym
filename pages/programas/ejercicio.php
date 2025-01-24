<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_GET['nombre']); ?></title>
    <?php 
    // Procesar series, repeticiones y tiempo desde la URL
    $series = isset($_GET['series']) ? $_GET['series'] : '0 series de 0 repeticiones';
    preg_match('/(\d+)\s*series\s*de\s*(\d+)\s*(repeticiones|segundos)\s*(por\s*l?ado)?/i', $series, $matches);
    
    $totalSeries = isset($matches[1]) ? (int)$matches[1] : 0;
    $repsPerSeries = isset($matches[2]) ? (int)$matches[2] : 0;
    $isPerSide = isset($matches[4]) && stripos($matches[4], 'lado') !== false;
    $isRepetition = isset($matches[3]) && strtolower($matches[3]) === 'repeticiones';
    ?>
    <style>
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


        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        

        .exercise-info {
            text-align: center;
            margin: 30px 0;
        }

        .exercise-info img {
            width: 50%;
            border-radius: 10px;
        }

        .timer {
            font-size: 30px;
            text-align: center;
            margin: 20px 0;
        }

        .footer button {
            background: #00043d;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #0f1041, #010036);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0f1041, #010036); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  color: #ffffff; /* Color del texto del botón */
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }


        .series-info {
            text-align: center;
            margin: 20px 10px;
            font-size: 20px;
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
    <div class="container">
        <header class="header">
            <h2><?php echo htmlspecialchars($_GET['nombre']); ?></h2>
        </header>
        <div class="exercise-info">
            <img src="<?php echo htmlspecialchars($_GET['imagen']); ?>" alt="<?php echo htmlspecialchars($_GET['nombre']); ?>" width="300" height="200">
            <p><?php echo htmlspecialchars($_GET['descripcion']); ?></p>
        </div>
        <div class="timer" id="timer">00:00</div>
        <div class="series-info">
            <?php if ($isRepetition): ?>
                <p>Series: <span id="currentSeries">0</span> / <?php echo $totalSeries; ?><br>
                   Repeticiones por serie: <?php echo $repsPerSeries; ?> repeticiones</p>
            <?php else: ?>
                <p>Series: <span id="currentSeries">0</span> / <?php echo $totalSeries; ?><br>
                   Tiempo por serie: <?php echo $repsPerSeries; ?> segundos</p>
            <?php endif; ?>
        </div>
        <footer class="footer">
            <button id="startButton">INICIAR</button>
            <button id="pauseButton" disabled>PAUSA</button>
            <button id="resetButton" disabled>REINICIAR</button>
            <button onclick="window.history.back()">VOLVER</button>
        </footer>
    </div>

    <script>
        let timerInterval;
        let elapsedTime = 0;
        let currentSeries = 0;
        let currentRepetition = 0;

        const totalSeries = <?php echo $totalSeries; ?>;
        const repsPerSeries = <?php echo $repsPerSeries; ?>;
        const isRepetition = <?php echo $isRepetition ? 'true' : 'false'; ?>;

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const sec = seconds % 60;
            return `${minutes < 10 ? '0' : ''}${minutes}:${sec < 10 ? '0' : ''}${sec}`;
        }

        function updateTimerDisplay() {
            const remainingTime = totalSeries * repsPerSeries - elapsedTime;
            document.getElementById('timer').textContent = formatTime(remainingTime > 0 ? remainingTime : 0);
            document.getElementById('currentSeries').textContent = currentSeries;
        }

        function updateTimer() {
            elapsedTime++;

            if (elapsedTime % repsPerSeries === 0) {
                currentSeries++;
            }

            if (currentSeries >= totalSeries) {
                clearInterval(timerInterval);
                alert("¡Has completado todas las series!");
                document.getElementById('startButton').disabled = false;
                document.getElementById('pauseButton').disabled = true;
                document.getElementById('resetButton').disabled = false;
            }

            updateTimerDisplay();
        }

        document.getElementById('startButton').addEventListener('click', function() {
            if (!timerInterval) {
                timerInterval = setInterval(updateTimer, 1000);
            }
            this.disabled = true;
            document.getElementById('pauseButton').disabled = false;
            document.getElementById('resetButton').disabled = false;
        });

        document.getElementById('pauseButton').addEventListener('click', function() {
            clearInterval(timerInterval);
            timerInterval = null;
            this.disabled = true;
            document.getElementById('startButton').disabled = false;
        });

        document.getElementById('resetButton').addEventListener('click', function() {
            clearInterval(timerInterval);
            timerInterval = null;
            elapsedTime = 0;
            currentSeries = 0;
            currentRepetition = 0;
            updateTimerDisplay();
            this.disabled = true;
            document.getElementById('startButton').disabled = false;
            document.getElementById('pauseButton').disabled = true;
        });

        // Actualiza el temporizador al cargar la página
        updateTimerDisplay();

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
