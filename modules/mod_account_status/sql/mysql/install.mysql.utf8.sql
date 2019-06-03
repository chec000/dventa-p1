CREATE TABLE IF NOT EXISTS `#__core_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'tipo de transacción order|adjustment|cancelation|etc',
  `correlation_id` int(10) unsigned DEFAULT NULL COMMENT 'id de la entidad relacionada con esta transacción',
  `balance_snapshot` int(11) NOT NULL COMMENT 'el saldo total del usuario después de aplicar esta transacción',
  `details` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'detalles extra relacionados con la transacción',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `applied_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

ALTER TABLE `#__core_user_transactions` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;