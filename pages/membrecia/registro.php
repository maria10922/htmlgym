<?php
// Archivo: procesarRegistro.php

// Cargar dependencias y controladores
require '/xampp/htdocs/htmlgym/pages/membrecia/Ctrl_Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $plan = $_POST['plan'] ?? '';

    // Validar que los datos necesarios están completos
    if (!empty($nombre) && !empty($email) && !empty($plan)) {
        try {
            // Crear la conexión a la base de datos
            $pdo = new PDO('mysql:host=localhost;dbname=gym_plataforma', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear una instancia del controlador
            $ctrlUsuario = new Ctrl_Usuario($pdo);

            // Registrar usuario y enviar correo
            $ctrlUsuario->guardarUsuarioYEnviarCorreo($nombre, $email, $telefono, $plan);
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    } else {
        echo "Por favor, completa todos los campos requeridos.";
    }
}
