SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__core_configs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  `visibility` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `core_configs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  `visibility` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
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

CREATE TABLE IF NOT EXISTS `core_motivale` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` enum('new','process') COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `core_motivale_request` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `action` enum('new','process','done','error') COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_motiva_request_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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

CREATE TABLE IF NOT EXISTS `core_products_x_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`category_id`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `core_products_x_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price` float(20,5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol_id` (`rol_id`,`product_id`),
  KEY `core_products_x_roles_ibfk_2` (`product_id`),
  CONSTRAINT `core_products_x_categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `core_product_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `editable` bit(1) NOT NULL DEFAULT b'0' COMMENT 'si es verdadero, indica que la categoría fue creada por un usuario, en vez de cargada desde motivale',
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `sort` int(11) NOT NULL COMMENT 'el orden a mostrar en las vistas',
  `enabled` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `core_product_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `core_product_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `core_product_categories_x_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol_id` (`rol_id`,`category_id`),
  KEY `core_product_categories_x_roles_ibfk_2` (`category_id`),
  CONSTRAINT `core_product_categories_x_roles_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `#__usergroups` (`id`),
  CONSTRAINT `core_product_categories_x_roles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `core_product_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `#__core_products_stock` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `stock` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`),
  KEY `core_products_stock_ibfk_1` (`product_id`),
  CONSTRAINT `core_products_stock_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `#__core_user_products_likes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `option` enum('like','dislike') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_2` (`product_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `core_user_products_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`),
  CONSTRAINT `core_user_products_likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `core_products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

SET FOREIGN_KEY_CHECKS=1;