-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2025 a las 01:59:05
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
-- Base de datos: `albarikoque`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `estado`) VALUES
(1, 'PIZZAS', 1),
(2, 'PASTAS', 1),
(3, 'PLATOS A LA CARTA', 1),
(4, 'POLLOS A LA BRASA', 1),
(5, 'FAST FOOD', 1),
(6, 'BEBIDAS', 1),
(7, 'TRAGOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `verify` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `correo`, `direccion`, `clave`, `token`, `verify`) VALUES
(6, 'jhordy', 'yuwenjhor@gmail.com', 'jr puno', '$2y$10$PaCvCFLrwAy0CZEc3ZSbCOjunr1LgtAm/i/.kpjp6V1dccKPyWXXS', '', 1),
(10, 'Miriam', 'condoraguilarmir@gmail.com', 'adsfd', '$2y$10$urT77COP6s.IRMTjHB3.M.yW5JMCfXOEcjSQGa9Cto.THSCFB7iz6', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `precio`, `cantidad`, `id_pedido`, `id_producto`) VALUES
(1, 30.00, 1, 1, 38),
(2, 22.00, 1, 1, 3),
(3, 28.00, 1, 2, 2),
(4, 30.00, 1, 2, 38),
(5, 22.00, 1, 3, 3),
(6, 30.00, 1, 3, 38),
(7, 22.00, 1, 4, 3),
(8, 25.00, 1, 4, 1),
(9, 22.00, 1, 5, 3),
(10, 28.00, 1, 5, 2),
(11, 22.00, 1, 6, 3),
(12, 30.00, 1, 6, 38),
(13, 18.00, 1, 7, 18),
(14, 20.00, 1, 7, 19),
(15, 18.00, 1, 7, 8),
(16, 28.00, 1, 8, 2),
(17, 15.00, 1, 8, 9),
(18, 17.00, 1, 8, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(80) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(150) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `proceso` enum('1','2','3') NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_transaccion`, `monto`, `estado`, `fecha`, `direccion`, `ciudad`, `id_cliente`, `proceso`, `id_usuario`) VALUES
(1, '09J64406TG3950130', 51.98, 'COMPLETED', '2025-11-18 14:16:01', 'jr puno', 'Puno', 6, '1', 1),
(2, '0F484475KX699134L', 57.99, 'COMPLETED', '2025-11-18 14:31:12', 'jr puno', 'Puno', 6, '1', 1),
(3, '79D23583CG137450U', 51.98, 'COMPLETED', '2025-11-18 14:36:56', 'jr puno', 'Puno', 6, '1', 1),
(4, '9WV20973TU897115K', 47.01, 'COMPLETED', '2025-11-18 14:44:49', 'jr puno', 'Puno', 6, '1', 1),
(5, '80702334EP0072452', 50.00, 'COMPLETED', '2025-11-18 14:55:05', 'jr puno', 'Puno', 6, '1', 1),
(6, '57A920623N017743C', 52.00, 'COMPLETED', '2025-11-18 14:56:42', 'jr puno', 'Puno', 6, '1', 1),
(7, '8S9729429U5300244', 56.00, 'COMPLETED', '2025-11-18 14:57:15', 'jr puno', 'Puno', 6, '1', 1),
(8, '34883082XR038024H', 60.00, 'COMPLETED', '2025-11-18 14:59:12', 'jr puno', 'Puno', 6, '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `estado`, `id_categoria`) VALUES
(1, 'AMERICANA', 'Contiene: Laminas de jamon, aceituna, salsa de tomate, queso mozzarella.', 25.00, 'assets/images/productos/20231003233819.jpg', 1, 1),
(2, 'VEGGY', 'Rodajas de tomate, cebolla blanca, champiñones, pimenton, aceituna, salsa de tomate, queso mozzarella.', 28.00, 'assets/images/productos/20231003233840.jpg', 1, 1),
(3, 'MARGARITA', 'Contiene: Rodajas de tomate, albanaca, aceitunas, salsa de tomate, queso mozzarella.', 22.00, 'assets/images/productos/20231003233857.jpg', 1, 1),
(4, 'SPAGETTI A LA BOLOGNESA', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur aperiam accusamus incidunt cum laudantium laborum ipsum magni sequi expedita ad, rem esse rerum ea saepe provident! Temporibus corporis atque earum?', 13.00, 'assets/images/productos/20231003233915.jpg', 1, 2),
(5, 'LASAGNA A LA BOLOGNESA', 'lorem ipsumsdd', 16.00, 'assets/images/productos/20231003233938.jpg', 1, 2),
(6, 'SPAGETTI A LA ALFREDO', 'si se puede', 14.00, 'assets/images/productos/20231003234219.jpg', 1, 2),
(7, 'Pollo a la Brasa', 'es rico cuando comes', 12.00, 'assets/images/productos/20230926232641.jpg', 1, 4),
(8, 'LASAGNA EXTREMA', 'dawdawda', 18.00, 'assets/images/productos/20231003234445.jpg', 1, 2),
(9, 'FETUCCINI A LA BOLOGNESA', 'lorem ipsum', 15.00, 'assets/images/productos/20231003234520.jpg', 1, 2),
(10, 'FETUCCINI A LO ALFREDO', 'lorem ipsum', 15.00, 'assets/images/productos/20231003234648.jpg', 1, 2),
(11, 'LOMO FINO SALTADO', '', 25.00, 'assets/images/productos/20231002234455.jpg', 0, 3),
(12, 'LOMO FINO SALTADO', '', 25.00, 'assets/images/productos/20231003234949.jpg', 1, 3),
(13, 'LOMO FINO SALTADO A LO POBRE', '', 28.00, 'assets/images/productos/20231003235018.jpg', 1, 3),
(14, 'BISTECK A LO POBRE', '', 25.00, 'assets/images/productos/20231003235051.jpg', 1, 3),
(15, 'BISTECK', '', 22.00, 'assets/images/productos/20231003235310.jpg', 1, 3),
(16, 'POLLO SALTADO', '', 20.00, 'assets/images/productos/20231003235405.jpg', 1, 3),
(17, 'TALLARIN SALTADO DE LOMO FINO', '', 25.00, 'assets/images/productos/20231003235456.jpg', 1, 3),
(18, 'TALLARIN SALTADO DE POLLO', '', 18.00, 'assets/images/productos/20231003235701.jpg', 1, 3),
(19, 'POLLO A LA PLANCHA', '', 20.00, 'assets/images/productos/20231003235724.jpg', 1, 3),
(20, 'CHAUFA DE POLLO', '', 12.00, 'assets/images/productos/20231003235749.jpg', 1, 3),
(21, '1/4 POLLO A LA BRASA', '', 17.00, 'assets/images/productos/20231003235822.jpg', 1, 4),
(22, '1 POLLO ENTERO', '', 65.00, 'assets/images/productos/20231003235847.jpg', 1, 4),
(23, 'MOSTRO', '', 19.00, 'assets/images/productos/20231003235905.jpg', 1, 4),
(24, 'HAMBURGUESA TRADICIONAL', '', 10.00, 'assets/images/productos/20231004000546.jpg', 1, 5),
(25, 'HAMBURGUESA ESPECIAL', '', 13.00, 'assets/images/productos/20231004000614.jpg', 1, 5),
(26, 'SALCHIPAPA DE LA CASA', '', 12.00, 'assets/images/productos/20231004000706.jpg', 1, 5),
(27, 'SALCHIPAPA ESPECIAL', '', 15.00, 'assets/images/productos/20231004000726.jpg', 1, 5),
(28, 'PAPAYA', '', 5.00, 'assets/images/productos/20231004000802.jpg', 1, 6),
(29, 'MARACUYA', '', 8.00, 'assets/images/productos/20231004000821.jpg', 1, 6),
(30, 'MILKSHAKE DE FRESA', '', 8.00, 'assets/images/productos/20231004000842.jpg', 1, 6),
(31, 'CAFE PASADO', '', 4.00, 'assets/images/productos/20231004000900.jpg', 1, 6),
(32, 'GASEOSAS ', '', 8.00, 'assets/images/productos/20231004000915.jpg', 1, 6),
(33, 'PISCO SOUR', '', 12.00, 'assets/images/productos/20231004000941.jpg', 1, 7),
(34, 'CHILCANO', '', 10.00, 'assets/images/productos/20231004000953.jpg', 1, 7),
(35, 'MOJITO', '', 12.00, 'assets/images/productos/20231003002255.jpg', 1, 7),
(36, 'PIÑA COLADA', '', 18.00, 'assets/images/productos/20231004001024.jpg', 1, 7),
(37, 'CALIENTITO', '', 10.00, 'assets/images/productos/20231004001039.jpg', 1, 7),
(38, 'CARNIVORA', '', 30.00, 'assets/images/productos/20231004001101.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `reset_token` varchar(120) DEFAULT NULL,
  `reset_expires_at` datetime DEFAULT NULL,
  `rol` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `correo`, `clave`, `reset_token`, `reset_expires_at`, `rol`, `estado`) VALUES
(1, 'Albarikoque', 'Albarikoque', 'admin@gmail.com', '$2y$10$MHbvt7WJ7DSY13f./cOo4.n5g793KuY4ptW5U9Uzn7PHu5ieGcucm', NULL, NULL, 'Administrador', 1),
(2, 'jhordy', 'castañeda', 'yuwenjhor@gmail.com', '$2y$10$.M7DTOlsddgrBk10106OD.MG69SEjxaZI5abpcsxY0lXOg0oRAgUq', NULL, NULL, 'Empleado', 1),
(3, 'Miriam', 'condor', 'jhordyyue@gmial.com', '$2y$10$rAvunwJi.T4Dt/HLGqGbbebymm8z0nGpzH2vhLDHMr6BAB6qUlb0W', NULL, NULL, 'Administrador', 1),
(4, 'edwin', 'meza', 'condoraguilarmir@gmail.com', '$2y$10$UY7em0IXVJRkysCQzXPeuuLU5Nj.MzZYG9n.O28SAgVxRPtxAc8U6', NULL, NULL, 'Empleado', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pedido` (`id_pedido`),
  ADD KEY `idx_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cliente` (`id_cliente`),
  ADD KEY `idx_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `fk_detalle_pedidos_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_pedidos_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
