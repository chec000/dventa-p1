SET FOREIGN_KEY_CHECKS=0;
--
-- Estructura de tabla para la tabla `core_user_cart_items`
--

CREATE TABLE IF NOT EXISTS `#__core_configs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  `visibility` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


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

CREATE TABLE IF NOT EXISTS `#__core_file_uploads` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ordering` int(10) NOT NULL,
  `state` TINYINT(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` DATETIME NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` enum('adjustments','corrections','extras','results','code','prols','crols','stock.upload','mechanic.points.upload','mechanic.products.upload','mechanic.objetives.upload') NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `core_file_uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

SET FOREIGN_KEY_CHECKS=1;