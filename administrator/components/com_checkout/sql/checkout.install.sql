SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__core_checkout_x_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `start_date` text NULL,
  `end_date` text NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol_id` (`rol_id`),
  CONSTRAINT `core_checkout_x_roles_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `#__usergroups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS  `#__core_adcinema` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` int(10) UNSIGNED NOT NULL,
  `ticket_type` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(125) COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `body_request` text COLLATE utf8_spanish2_ci NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_purchased` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_adcinema_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_configs`
--
CREATE TABLE IF NOT EXISTS `#__core_configs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(200)  NOT NULL ,
  `value` TEXT NOT NULL ,
  `visibility` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;


--
-- Estructura de tabla para la tabla `core_orders`
--
CREATE TABLE IF NOT EXISTS `#__core_orders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `created_by_id` int(10) DEFAULT NULL,
  `total` float NOT NULL,
  `revision` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `core_orderss_ibfk_1` (`user_id`),
  KEY `core_orders_ibfk_2` (`created_by_id`),
  CONSTRAINT `core_orders_ibfk_2` FOREIGN KEY (`created_by_id`) REFERENCES `#__users` (`id`),
  CONSTRAINT `core_orderss_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_order_addressses`
--
CREATE TABLE IF NOT EXISTS `#__core_order_addressses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `street` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `ext_number` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `int_number` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `town` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_order_addressses_ibfk_1` (`order_id`),
  KEY `core_order_addressses_ibfk_2` (`user_id`),
  CONSTRAINT `core_order_addressses_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `#__core_orders` (`id`),
  CONSTRAINT `core_order_addressses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_products`
--
CREATE TABLE IF NOT EXISTS `core_products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `description` text COLLATE utf8_spanish2_ci,
  `brand` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `real_price` decimal(8,2) DEFAULT NULL COMMENT 'campo `Precio` en motivale',
  `price` int(10) UNSIGNED DEFAULT NULL COMMENT 'campo `Puntos` desde motivale',
  `payload` text COLLATE utf8_spanish2_ci COMMENT 'JSON original recibido desde motivale',
  `enabled` bit(1) NOT NULL DEFAULT b'0',
  `editable` bit(1) DEFAULT b'0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `AK_sku` (`sku`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_order_addressses`
--
CREATE TABLE IF NOT EXISTS `#__core_order_products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `description` text COLLATE utf8_spanish2_ci NOT NULL,
  `brand` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `real_price` float NOT NULL,
  `price` float NOT NULL,
  `payload` text COLLATE utf8_spanish2_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `core_order_products_ibfk_2` (`product_id`),
  CONSTRAINT `core_order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `#__core_orders` (`id`),
  CONSTRAINT `core_order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_cedis`
--
CREATE TABLE IF NOT EXISTS `#__core_cedis` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cedis_id` int(10) UNSIGNED NOT NULL,
  `names_cedis` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `ext_number` int(10) UNSIGNED NOT NULL,
  `int_number` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estate` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `state` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `zip_code` int(10) UNSIGNED NOT NULL,
  `telephone` varchar(18) COLLATE utf8_spanish2_ci NOT NULL,
  `extra` text COLLATE utf8_spanish2_ci,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `active` bit(1) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publish_up` datetime DEFAULT NULL,
  `publish_down` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_order_cedis`
--
CREATE TABLE IF NOT EXISTS `#__core_order_cedis` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cedis_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_order_cedis_ibfk_1` (`cedis_id`),
  KEY `core_order_cedis_ibfk_2` (`order_id`),
  CONSTRAINT `core_order_cedis_ibfk_1` FOREIGN KEY (`cedis_id`) REFERENCES `#__core_cedis` (`id`),
  CONSTRAINT `core_order_cedis_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `#__core_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_survey_questions`
--
CREATE TABLE IF NOT EXISTS `#__core_survey_questions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `question` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `answer` text COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `core_survey_questions_ibfk_2` (`user_id`),
  CONSTRAINT `core_survey_questions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `zip_codes`
--
CREATE TABLE IF NOT EXISTS `#__zip_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zip_code` varchar(8) NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  `town` varchar(30) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `zip_code` (`zip_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_user_cart_items`
--
CREATE TABLE IF NOT EXISTS `#__core_user_cart_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '1',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `AK_cart` (`user_id`,`product_id`),
  KEY `core_user_cart_ibfk_2` (`product_id`),
  CONSTRAINT `core_user_cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`),
  CONSTRAINT `core_user_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Estructura de tabla para la tabla `core_user_transactions`
--
CREATE TABLE IF NOT EXISTS `#__core_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'tipo de transacción order|adjustment|cancelation|etc',
  `correlation_id` int(10) unsigned DEFAULT NULL COMMENT 'id de la entidad relacionada con esta transacción',
  `balance_snapshot` int(11) NOT NULL COMMENT 'el saldo total del usuario después de aplicar esta transacción',
  `details` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'detalles extra relacionados con la transacción',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `applied_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `core_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

ALTER TABLE `#__core_user_transactions` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Estructura de tabla para la tabla `core_products_stock`
--

CREATE TABLE IF NOT EXISTS `#__core_products_stock` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `stock` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `core_products_stock_ibfk_1` (`product_id`),
  CONSTRAINT `core_products_stock_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `#__zip_codes`
--


SET FOREIGN_KEY_CHECKS=1;