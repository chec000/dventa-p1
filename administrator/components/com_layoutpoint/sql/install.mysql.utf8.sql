CREATE TABLE IF NOT EXISTS `#__core_file_uploads` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`reason_id` INT(11)  NOT NULL ,
`user_id` INT(11)  NOT NULL ,
`description` VARCHAR(255)  NOT NULL ,
`file_name` VARCHAR(255)  NOT NULL ,
`file_type` ENUM('adjustments','corrections','extras','results','code'),
`uploaded_at` TIMESTAMP NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__core_pmr_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mes` int(10) unsigned NOT NULL,
  `anio` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ventas` float NOT NULL,
  `cuota` float NOT NULL,
  `puntos` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mes_anio` (`mes`,`anio`,`user_id`) USING BTREE,
  KEY `pmr_rules_ibfk_1` (`user_id`),
  CONSTRAINT `pmr_rules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `#__core_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'tipo de transacci�n order|adjustment|cancelation|etc',
  `correlation_id` int(10) unsigned DEFAULT NULL COMMENT 'id de la entidad relacionada con esta transacci�n',
  `balance_snapshot` int(11) NOT NULL COMMENT 'el saldo total del usuario despu�s de aplicar esta transacci�n',
  `details` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'detalles extra relacionados con la transacci�n',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `applied_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `core_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

