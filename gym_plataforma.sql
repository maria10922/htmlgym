-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2025 a las 15:38:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gym_plataforma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `imagen_producto` varchar(255) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_programas`
--

CREATE TABLE `detalles_programas` (
  `id` int(11) NOT NULL,
  `programa` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_programas`
--

INSERT INTO `detalles_programas` (`id`, `programa`, `descripcion`, `imagen`, `nivel`) VALUES
(1, 'Ayuda para Principiantes', '¿Quieres empezar a ponerte en forma? Prueba uno de estos ejercicios diseñados para principiantes. Cada uno está enfocado en desarrollar fuerza, resistencia y técnica.', '/htmlgym/imagenes/Ayuda para principiantes.jpg', 'Principiante'),
(2, 'Entrenamiento Avanzado', '¡Lleva tu entrenamiento al siguiente nivel con estos ejercicios avanzados!', '/htmlgym/imagenes/entrenamiento_avanzado.jpg', 'Avanzado'),
(3, 'Pérdida de Peso', 'Estos ejercicios están diseñados para ayudarte a quemar calorías y perder peso de manera efectiva.', '/htmlgym/imagenes/pérdida_peso.jpg', 'Pérdida de Peso'),
(4, 'Sin equipo', 'Entrena en cualquier lugar sin necesidad de equipo. Estos ejercicios son perfectos para mantenerse activo sin pesas ni máquinas.', '/htmlgym/imagenes/sin_equipo.jpg', 'Sin equipo'),
(5, 'Entrenamiento de fuerza', 'Desarrolla fuerza y potencia con estos ejercicios de alta intensidad. Perfectos para mejorar el rendimiento y la tonificación muscular.', '/htmlgym/imagenes/entrenamiento_fuerza.jpg', 'Entrenamiento de fuerza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `series` varchar(50) DEFAULT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `nombre`, `descripcion`, `series`, `programa_id`, `imagen`) VALUES
(1, 'Sentadillas', 'Fortalece piernas y glúteos.', '3 series de 12 repeticiones', 1, '/htmlgym/imagenes/Sentadillas.jpg'),
(2, 'Flexiones', 'Trabaja pecho y tríceps.', '3 series de 10 repeticiones', 1, '/htmlgym/imagenes/Flexiones.jpg'),
(3, 'Jalón al pecho', 'Fortalece la espalda.', '3 series de 12 repeticiones', 1, '/htmlgym/imagenes/Jalón al pecho.jpg'),
(4, 'Curl de bíceps', 'Fortalece los brazos.', '3 series de 12 repeticiones', 1, '/htmlgym/imagenes/Curl de bíceps.jpg'),
(5, 'Plancha', 'Fortalece el core.', '3 series de 30 segundos', 1, '/htmlgym/imagenes/Plancha.jpg'),
(6, 'Peso muerto', 'Fortalece espalda baja y piernas.', '4 series de 8 repeticiones', 2, '/htmlgym/imagenes/deadlift.jpg'),
(7, 'Pull-ups', 'Trabaja espalda y bíceps.', '4 series de 8 repeticiones', 2, '/htmlgym/imagenes/Pull-ups.jpg'),
(8, 'Burpees', 'Ejercicio de cuerpo completo.', '4 series de 15 repeticiones', 2, '/htmlgym/imagenes/Burpees.jpg'),
(9, 'Sentadillas con pistola', 'Fortalece las piernas.', '3 series de 10 por pierna', 2, '/htmlgym/imagenes/Sentadillas con pistola.jpg'),
(10, 'Kettlebell Swing', 'Trabaja glúteos y espalda baja.', '4 series de 12 repeticiones', 2, '/htmlgym/imagenes/Kettlebell Swing.jpg'),
(11, 'Correr', 'Ideal para quemar calorías.', '30 minutos', 3, '/htmlgym/imagenes/Correr.jpg'),
(12, 'Sprints', 'Mejora la resistencia cardiovascular.', '5 series de 20 segundos', 3, '/htmlgym/imagenes/Sprints.jpg'),
(13, 'Mountain Climbers', 'Quema calorías y mejora la agilidad.', '4 series de 30 segundos', 3, '/htmlgym/imagenes/Mountain climbers.jpg'),
(14, 'Jumping Jacks', 'Ejercicio aeróbico eficaz.', '4 series de 30 segundos', 3, '/htmlgym/imagenes/Jumping Jacks.jpg'),
(15, 'Skipping', 'Excelente para la quema de grasa.', '3 series de 2 minutos', 3, '/htmlgym/imagenes/Skipping.jpg'),
(16, 'Sentadillas con salto', 'Mejora fuerza y explosividad.', '3 series de 15 repeticiones', 4, '/htmlgym/imagenes/Sentadillas con salto.jpg'),
(17, 'Mountain climbers', 'Trabaja core y piernas.', '3 series de 20 repeticiones', 4, '/htmlgym/imagenes/Mountain climbers.jpg'),
(18, 'Lunges', 'Fortalece piernas y glúteos.', '3 series de 12 repeticiones', 4, '/htmlgym/imagenes/Lunges.jpg'),
(19, 'Flexiones de brazos', 'Trabaja pecho y tríceps.', '3 series de 12 repeticiones', 4, '/htmlgym/imagenes/Flexiones de brazos.jpg'),
(20, 'Plank lateral', 'Fortalece el core.', '3 series de 30 segundos por lado', 4, '/htmlgym/imagenes/Plank lateral.jpg'),
(21, 'Sentadillas con peso', 'Fortalece piernas y glúteos.', '4 series de 10 repeticiones', 5, '/htmlgym/imagenes/Sentadillas con peso.jpg'),
(22, 'Press de banca', 'Trabaja pecho y tríceps.', '4 series de 8 repeticiones', 5, '/htmlgym/imagenes/Press de banca.jpg'),
(23, 'Peso muerto', 'Fortalece espalda baja y piernas.', '4 series de 8 repeticiones', 5, '/htmlgym/imagenes/Peso muerto.jpg'),
(24, 'Dominadas', 'Fortalece espalda y bíceps.', '4 series de 6 repeticiones', 5, '/htmlgym/imagenes/Dominadas.jpg'),
(25, 'Press militar', 'Fortalece hombros y tríceps.', '4 series de 8 repeticiones', 5, '/htmlgym/imagenes/Press militar.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `plan` enum('basico','avanzado','premium') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id`, `nombre`, `email`, `telefono`, `plan`, `fecha_registro`) VALUES
(1, 'maria', 'mq451180@gmail.com', '1234567890', 'basico', '2025-01-11 13:45:33'),
(6, 'maria', 'mariacd23@gmail.com', '1234567890', 'basico', '2025-01-21 14:54:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `message`, `sender`, `created_at`) VALUES
(1, 'hola', 'yo', '2025-01-21 19:41:55'),
(18, 'hi', 'otro', '2025-01-21 20:33:09'),
(19, 'hola', 'yo', '2025-01-21 20:33:16'),
(20, 'hokogk', 'yo', '2025-01-21 20:39:31'),
(21, 'fgimdo', 'yo', '2025-01-21 20:39:32'),
(22, 'foigbmodfg', 'yo', '2025-01-21 20:39:34'),
(23, 'gdfgbdy', 'yo', '2025-01-21 20:39:35'),
(24, 'fgng', 'yo', '2025-01-21 20:39:36'),
(25, 'fhghfh', 'yo', '2025-01-21 20:39:37'),
(26, 'fhgfh', 'yo', '2025-01-21 20:39:38'),
(27, 'fhfgh', 'yo', '2025-01-21 20:39:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_programas`
--

CREATE TABLE `registro_programas` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) DEFAULT NULL,
  `programa` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_programas`
--

INSERT INTO `registro_programas` (`id`, `nombre_usuario`, `programa`, `fecha_registro`) VALUES
(11, 'maria', 'Sin equipo', '2025-01-12 06:08:21'),
(12, 'maria', 'Ayuda para principiantes', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `estatura` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `email`, `password`, `foto_perfil`, `peso`, `estatura`) VALUES
(7, 'maria', 'mq451180@gmail.com', '$2y$10$xVzyJdn07/4NjI6r2w8C/u1a6xjhxUwg7LhRVuncovmqFDD7odrH.', 'uploads/Descripción.png', 78.00, 170.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_programas`
--
ALTER TABLE `detalles_programas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programa_id` (`programa_id`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_programas`
--
ALTER TABLE `registro_programas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_programas`
--
ALTER TABLE `detalles_programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `registro_programas`
--
ALTER TABLE `registro_programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`programa_id`) REFERENCES `detalles_programas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_programas`
--
ALTER TABLE `registro_programas`
  ADD CONSTRAINT `registro_programas_ibfk_1` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
