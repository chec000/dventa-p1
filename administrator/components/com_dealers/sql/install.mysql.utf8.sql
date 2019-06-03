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
  `publish_up` datetime,
  `publish_down` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `#__core_users_cedis_map` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `userid` INT(10) NOT NULL DEFAULT '0' ,
  `cedisid` INT(4) NOT NULL DEFAULT '0',
  `state` TINYINT(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
