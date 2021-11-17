-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-10-2021 a las 00:04:57
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--
DROP DATABASE IF EXISTS `tienda`;
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thumbnail` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Administracion de categorias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `sku` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `descriptions` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `sale_price` float NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `discount_available` float NOT NULL DEFAULT '0',
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `dimensions` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `thumbnail` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `images` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stock` int(11) NOT NULL DEFAULT '0',
  `ranking` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `optional_name` varchar(250) DEFAULT NULL,
  `optional_description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Catalogo de productos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categorias donde se listara los productos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `parameter` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
  `value` VARCHAR(250) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
  PRIMARY KEY (`id`) USING BTREE
)
COMMENT='Auxiliar para sistema'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=101
;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `owner` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `oauth_provider` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `roles` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `current_session` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Catalogo de usuarios de sistema' ROW_FORMAT=DYNAMIC;

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NULL DEFAULT NULL,
  `amount` FLOAT NULL DEFAULT NULL,
  `ship_price` FLOAT NULL DEFAULT NULL,
  `shipping_address` VARCHAR(500) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
  `order_date` DATETIME NULL DEFAULT NULL,
  `ship_date` DATETIME NULL DEFAULT NULL,
  `shipper_id` INT(11) NULL DEFAULT NULL,
  `shipper_tracking` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
  `payment_data` VARCHAR(10000) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
  `coupon` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
)
COMMENT='lista de pedidos'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=8
;


--
-- Estructura de tabla para la tabla `order_detail`
--
CREATE TABLE `order_detail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL DEFAULT '0',
  `product_id` INT(11) NOT NULL DEFAULT '0',
  `price` FLOAT NOT NULL DEFAULT '0',
  `discount` INT(11) NOT NULL DEFAULT '0',
  `discount_available` FLOAT NOT NULL DEFAULT '0',
  `quantity` INT(11) NOT NULL DEFAULT '0',
  `amount` FLOAT NOT NULL DEFAULT '0',
  `selected_options` VARCHAR(1000) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
  PRIMARY KEY (`id`) USING BTREE
)
COMMENT='detalles de la orden generada'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

--
-- Estructura de tabla para la tabla `order_log`
--
CREATE TABLE `order_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL DEFAULT '0',
  `status` INT(11) NOT NULL DEFAULT '0',
  `update_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comments` VARCHAR(250) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
  PRIMARY KEY (`id`) USING BTREE
)
COMMENT='Herramienta para seguimiento de cambio de estado'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

--
-- Estructura de tabla para la tabla `coupon`
--
CREATE TABLE `coupon` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
  `valor` FLOAT NULL DEFAULT NULL,
  `tipo` INT(11) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;




--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
