-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-04-2023 a las 20:01:39
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `event`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(200) NOT NULL,
  `nomevent` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `localizacion` varchar(100) NOT NULL,
  `entrada` varchar(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nomevent`, `categoria`, `fecha`, `localizacion`, `entrada`, `descripcion`, `imagen`, `usuario`, `correo`) VALUES
(22, 'Evento de prueba numero 22', 'deportes', '2023-04-14', 'Madrid', 'Gratis', 'Partido futbol sala', 'Imagenes/imagen8.jpg', 'Ana', 'ana@gmail.com'),
(23, 'Evento con Imagen prueba 1', 'conciertos', '2023-04-21', 'Barcelona', 'Pago', 'Esto es un evento de concierto de prueba con imagenes', 'Imagenes/imagen5.jpg', 'Ana', 'ana@gmail.com'),
(27, 'Prueba 19mil', 'cultura', '2023-04-22', 'Asturias', 'Pago', 'Esto es otra prueba mas', 'Imagenes/imagen3.jpg', 'Ana', NULL),
(29, 'Quedada en bici por rutas de montaña', 'deportes', '2023-04-27', 'Oviedo', 'Gratis', 'Hola, busco gente que quiera quedar para andar en bici. Estoy retomando esto y me gustaría poder hacerlo acompañado.', 'Imagenes/nature-bicycle-mountain-bikes-wallpaper-preview.jpg', 'Jorge', NULL),
(30, 'Torneo de cartas Magic', 'cultura', '2023-04-20', 'TuTiendaMagic, Madrid', 'Gratis', 'Estamos montando un torneo del juego de cartas Magic, en TuTiendaMagic. Estais todos invitados al evento.', 'Imagenes/magic.jpg', 'Juan', NULL),
(31, 'Quedada para jugar al Poker', 'cultura', '2023-04-21', 'Madrid, Móstoles', 'Gratis', 'Unos amigos y yo estamos quedando en un bar de la zona para jugar al Poker. Cualquier interesado es bienvenido. Los viernes a las 22:00.', 'Imagenes/poker.jpg', 'Fran', NULL),
(32, 'Ruta de senderismo por el Val D''Aran', 'viajes', '2023-05-26', 'Circuito de los 7 lagos de Colomèrs.', 'Gratis', 'Estamos haciendo una quedada para hacer esta ruta increíble de senderismo. Somos 5 amigos y querríamos que mas gente se apuntase.', 'Imagenes/senderismo.jpg', 'event', NULL),
(33, 'Fiesta en la playa', 'conciertos', '2023-06-05', 'Playa de Mareas en Alicante', 'Pago', 'Estamos montando una fiesta con equipos de música y DJ. Hay que pagar una pequeña entrada, pero esperamos que se una mucha gente.', 'Imagenes/viva_el_rave.jpg', 'Ana', NULL),
(34, 'Mundial de Resistencia de Karts', 'deportes', '2023-04-27', 'Circuito de Fuensalida, Toledo.', 'Pago', 'Estamos montando un evento de karts, cada uno debe pagar su entrada. Pero necesitamos ser mínimo 20 personas.', 'Imagenes/karts.jpg', 'event', NULL),
(35, 'Pachanga de Baloncesto', 'deportes', '2023-04-21', 'Polideportivo de Móstoles', 'Gratis', 'Estamos montando un torneíllo de baloncesto. Buscamos mas gente para el evento y luego publicaríamos los días de partido.', 'Imagenes/baloncesto.jpg', 'Fran', NULL),
(36, 'Turismo por Santiago de Compostela', 'viajes', '2023-04-30', 'Santiago de Compostela', 'Gratis', 'Una amigas y yo vamos a hacer un viaje a Santiago y buscamos gente de allí que nos quiera enseñar la ciudad.', 'Imagenes/santiago-de-compostela.jpg', 'Helena', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `join_event`
--

CREATE TABLE `join_event` (
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `join_action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `contraseña`, `correo`, `nombre`, `fecha`) VALUES
(3, 'event', 'event@gmail.com', 'event', '0000-00-00'),
(4, '123', 'ana@gmail.com', 'Ana', '0000-00-00'),
(6, '123', 'Jorge@gmail.com', 'Jorge', '2023-04-12'),
(7, '123', 'juan@ifp.es', 'Juan', '2023-04-15'),
(8, '123', 'ana2@gmail.com', 'Ana', '2023-04-16'),
(9, '123', 'Fran@hotmail.com', 'Fran', '2023-04-17'),
(10, '123', 'Helena@gmail.com', 'Helena', '2023-04-17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `join_event`
--
ALTER TABLE `join_event`
  ADD UNIQUE KEY `indice eventos` (`id_usuario`,`id_evento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `event_id` (`usuario_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
