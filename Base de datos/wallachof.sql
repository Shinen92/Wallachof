-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2018 a las 18:03:11
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wallachof`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria`) VALUES
('Cocina'),
('Deporte'),
('Herramientas'),
('Juegos'),
('Varios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_origen` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `contenido` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_origen`, `id_destinatario`, `fecha`, `contenido`) VALUES
(1, 11, 8, '2018-01-24 17:44:06', 'Hola'),
(2, 11, 8, '2018-01-24 17:45:33', 'Hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privado`
--

CREATE TABLE `privado` (
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `privado`
--

INSERT INTO `privado` (`hash`) VALUES
('hashparacodigkaklsdpdflkw3890834jpr6df456ask');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_vendedor` int(11) DEFAULT NULL,
  `id_comprador` int(11) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `fecha_compra` datetime DEFAULT NULL,
  `localizacion` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `categoria` varchar(100) DEFAULT NULL,
  `precio_oferta` float DEFAULT NULL,
  `foto` text,
  `fecha_oferta` datetime DEFAULT NULL,
  `producto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `insert_productos` BEFORE INSERT ON `productos` FOR EACH ROW set new.fecha_oferta = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol`) VALUES
('Administrador'),
('Invitado'),
('Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `avatar` text,
  `rol` varchar(100) DEFAULT NULL,
  `contrasena` text,
  `confirmado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `email`, `nombre`, `avatar`, `rol`, `contrasena`, `confirmado`, `fecha_registro`) VALUES
(6, 'Francisco', 'Wallachof@gmail.com', 'Francisco', 'thumb-1920-751080.png', NULL, 'd41d8cd98f00b204e9800998ecf8427e', 1, '2018-01-22 19:17:22'),
(7, 'Francisco2', 'Wallachof@gmail.com', 'Fran', 'thumb-1920-751080.png', NULL, 'd41d8cd98f00b204e9800998ecf8427e', 1, '2018-01-24 15:12:17'),
(8, 'Prueba', 'Wallachof@gmail.com', 'Prueba', 'thumb-1920-751080.png', NULL, 'd41d8cd98f00b204e9800998ecf8427e', 1, '2018-01-24 17:25:17'),
(9, 'Prueba2', 'Wallachof@gmail.com', 'Prueba2', 'thumb-1920-751080.png', NULL, 'd41d8cd98f00b204e9800998ecf8427e', 1, '2018-01-24 17:27:27'),
(10, 'Prueba3', 'Wallachof@gmail.com', 'prueba', 'thumb-1920-751080.png', NULL, 'c893bad68927b457dbed39460e6afd62', 0, '2018-01-24 17:30:33'),
(11, 'Prueba4', 'Wallachof@gmail.com', 'prueba', 'thumb-1920-751080.png', NULL, 'c893bad68927b457dbed39460e6afd62', 1, '2018-01-24 17:31:55');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `insert_usuarios` BEFORE INSERT ON `usuarios` FOR EACH ROW set new.fecha_registro = NOW()
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_ibfk_2` (`id_destinatario`),
  ADD KEY `mensajes_ibfk_1` (`id_origen`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_ibfk_2` (`id_comprador`),
  ADD KEY `productos_ibfk_1` (`id_vendedor`),
  ADD KEY `productos_ibfk_3` (`categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `usuarios_ibfk_1` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_origen`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_vendedor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_comprador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
