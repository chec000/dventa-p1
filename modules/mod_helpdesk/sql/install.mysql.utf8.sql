CREATE TABLE IF NOT EXISTS `#__core_configs` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
 `value` text COLLATE utf8_spanish2_ci,
 `visibility` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;