-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 03-03-2024 a las 20:37:15
-- Versión del servidor: 8.0.35
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_siroko`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address_data`
--

DROP TABLE IF EXISTS `address_data`;
CREATE TABLE `address_data` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comunity` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `active` tinyint(1) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts_items`
--

DROP TABLE IF EXISTS `carts_items`;
CREATE TABLE `carts_items` (
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `active`, `product_id`, `tid`, `state`) VALUES
('018df9e3-0313-709c-96da-26db8af79acf', 1, '018df9df-8640-7dc1-bd2f-e7a56f0bb87e', 'GF54787FGD5487F4GFD54', 1),
('018df9e3-1895-7597-9794-c54d2d724260', 1, '018df9df-8640-7dc1-bd2f-e7a56f0bb87e', '45JHG4F5H4JJ4G5HJG45', 1),
('018df9e3-4311-7540-9a2b-2ad88d39ad20', 1, '018df9e0-7e89-7b02-8571-09b5258106b5', 'D45FDG5GFH45HG4F5H54', 1),
('018df9e3-6109-76a1-b89e-37c5f9b3fb62', 1, '018df9e0-7e89-7b02-8571-09b5258106b5', '45FGD4FD4DFG45645FDG', 1),
('018df9e3-7664-7a6b-8643-6fc4de032289', 1, '018df9e0-7e89-7b02-8571-09b5258106b5', 'H46G5FD645HGF45645G6', 2),
('018df9e3-8d3e-7eb4-867c-44e5723945cc', 1, '018df9e1-99ee-73aa-b48c-ca2445d67d7a', '45FDG45SFD56456FSDG5', 2),
('018df9e7-b433-7d1d-b45a-fb50f06f005d', 1, '018df9e1-99ee-73aa-b48c-ca2445d67d7a', '1H5GJF546JHG654JFGH6', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_snapshot`
--

DROP TABLE IF EXISTS `item_snapshot`;
CREATE TABLE `item_snapshot` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE `model` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model`
--

INSERT INTO `model` (`id`, `name`, `description`) VALUES
('018df9de-0eea-740a-8005-031fb3d977ec', 'W3 NEUQUÉN LF', 'Chaqueta lifestyle para hombre'),
('018df9de-481c-7e35-9f23-b9f6669c2674', 'W1 SKYWALK LF', 'Chaqueta lifestyle para hombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_data_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_data_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_item_snapshot`
--

DROP TABLE IF EXISTS `order_item_snapshot`;
CREATE TABLE `order_item_snapshot` (
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_snapshot_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_data`
--

DROP TABLE IF EXISTS `payment_data`;
CREATE TABLE `payment_data` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracing_code` int NOT NULL,
  `variant` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `model_id`, `tracing_code`, `variant`, `name`, `price`) VALUES
('018df9df-8640-7dc1-bd2f-e7a56f0bb87e', '018df9de-0eea-740a-8005-031fb3d977ec', 32001, 'S', 'Talla S', 79.99),
('018df9e0-7e89-7b02-8571-09b5258106b5', '018df9de-0eea-740a-8005-031fb3d977ec', 32002, 'M', 'Talla M', 79.99),
('018df9e1-896b-7bde-bde5-6d40003d7d58', '018df9de-481c-7e35-9f23-b9f6669c2674', 15002, 'M', 'Talla M', 59.99),
('018df9e1-99ee-73aa-b48c-ca2445d67d7a', '018df9de-481c-7e35-9f23-b9f6669c2674', 15003, 'L', 'Talla L', 59.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondSurname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `active` tinyint(1) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `address_data`
--
ALTER TABLE `address_data`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BA388B78D9F6D38` (`order_id`),
  ADD KEY `IDX_BA388B7A76ED395` (`user_id`);

--
-- Indices de la tabla `carts_items`
--
ALTER TABLE `carts_items`
  ADD PRIMARY KEY (`cart_id`,`item_id`),
  ADD KEY `IDX_6DBF34661AD5CDBF` (`cart_id`),
  ADD KEY `IDX_6DBF3466126F525E` (`item_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251E4584665A` (`product_id`);

--
-- Indices de la tabla `item_snapshot`
--
ALTER TABLE `item_snapshot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4040DDFE126F525E` (`item_id`);

--
-- Indices de la tabla `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F52993986C1056A4` (`address_data_id`),
  ADD UNIQUE KEY `UNIQ_F52993982EBCAFD6` (`payment_data_id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Indices de la tabla `order_item_snapshot`
--
ALTER TABLE `order_item_snapshot`
  ADD PRIMARY KEY (`order_id`,`item_snapshot_id`),
  ADD KEY `IDX_ED23952C8D9F6D38` (`order_id`),
  ADD KEY `IDX_ED23952C9B516168` (`item_snapshot_id`);

--
-- Indices de la tabla `payment_data`
--
ALTER TABLE `payment_data`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD7975B7E7` (`model_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B78D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `carts_items`
--
ALTER TABLE `carts_items`
  ADD CONSTRAINT `FK_6DBF3466126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_6DBF34661AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_F0FE25274584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `item_snapshot`
--
ALTER TABLE `item_snapshot`
  ADD CONSTRAINT `FK_4040DDFE126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Filtros para la tabla `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993982EBCAFD6` FOREIGN KEY (`payment_data_id`) REFERENCES `payment_data` (`id`),
  ADD CONSTRAINT `FK_F52993986C1056A4` FOREIGN KEY (`address_data_id`) REFERENCES `address_data` (`id`),
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `order_item_snapshot`
--
ALTER TABLE `order_item_snapshot`
  ADD CONSTRAINT `FK_ED23952C8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_ED23952C9B516168` FOREIGN KEY (`item_snapshot_id`) REFERENCES `item_snapshot` (`id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
