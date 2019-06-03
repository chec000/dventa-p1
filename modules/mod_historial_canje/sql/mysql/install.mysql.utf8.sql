 CREATE TABLE IF NOT EXISTS `#__core_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `revision` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `core_orderss_ibfk_1` (`user_id`),
  KEY `core_orders_ibfk_2` (`created_by_id`),
  CONSTRAINT `core_orders_ibfk_2` FOREIGN KEY (`created_by_id`) REFERENCES `#__users` (`id`),
  CONSTRAINT `core_orderss_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


CREATE TABLE IF NOT EXISTS `#__core_products` (
  `id` int(10) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `#__core_order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `sku` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `description` text COLLATE utf8_spanish2_ci NOT NULL,
  `brand` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `real_price` float NOT NULL,
  `price` float NOT NULL,
  `payload` text COLLATE utf8_spanish2_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
   PRIMARY KEY (`id`),
   KEY `core_order_productss_ibfk_1` (`order_id`),
   KEY `core_order_products_ibfk_2` (`product_id`),
   CONSTRAINT `core_order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `#__core_orders` (`id`),
   CONSTRAINT `core_order_productss_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `#__core_products` (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
