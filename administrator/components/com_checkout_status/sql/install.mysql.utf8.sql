SET FOREIGN_KEY_CHECKS=0;
CREATE TABLE IF NOT EXISTS `#__core_configs` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
	`value` text COLLATE utf8_spanish2_ci,
	`visibility` bit(1) NOT NULL,
	PRIMARY KEY (`id`)
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

CREATE TABLE IF NOT EXISTS `#__core_checkout_log` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(10) NOT NULL,
	`action` enum('open','close','change') NOT NULL,
	`type` varchar(255) NOT NULL,
	`applied_at` timestamp NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `core_checkout_log_ibfk_1` (`user_id`),
	CONSTRAINT `core_checkout_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
SET FOREIGN_KEY_CHECKS=1;