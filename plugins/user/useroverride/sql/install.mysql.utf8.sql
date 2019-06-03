CREATE TABLE IF NOT EXISTS `#__core_pmr_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `profile_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `visible` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__core_pmr_profiles` (`id`, `group_id`, `profile_name`, `visible`) VALUES
(1, 12, 'Asistente de F&I', 1),
(2, 13, 'Asesor de venta', 1),
(3, 11, 'F&I Manager', 1),
(4, 10, 'Gerente de ventas (Nuevos)', 1),
(5, 15, 'Gerente de Ventas (Nuevos y seminuevos)', 1),
(6, 14, 'Gerente de Ventas (Seminuevos)', 1),
(7, 16, 'Gerente Distrital', 0),
(8, 17, 'Gerente Regional', 0);

CREATE TABLE IF NOT EXISTS `#__core_user_info` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`midname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`lastname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`curp` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`ine` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`gmin` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`telephone` VARCHAR(255) NOT NULL ,
	`cellphone` VARCHAR(255) NOT NULL ,
	`secretword` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`secretwordans` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`birthday` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`profile` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`ip` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
	PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `#__core_user_info` ADD UNIQUE `user_joomla` (`user_id`);

CREATE TABLE IF NOT EXISTS `#__core_pmr_salesteam` (
	`id` INT(11) NOT NULL AUTO_INCREMENT ,
	`user_id` INT(11) NOT NULL ,
	`gte` INT(11) NOT NULL ,
	`fyi` INT(11) NOT NULL ,
	`afyi` INT(11) NOT NULL ,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__core_pmr_users_blacklist` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE= InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

INSERT INTO `#__core_pmr_users_blacklist` (`id`, `rfc`) VALUES
(1, 'YEHU811009'),
(2, 'PASE700816'),
(3, 'AUML850816'),
(4, 'RULJ700521'),
(5, 'CAMF890707'),
(6, 'SOMI900701'),
(7, 'MERF750515'),
(8, 'SOBB740906'),
(9, 'ERJ790731'),
(10, 'MXME831123'),
(11, 'HERJ790731'),
(12, 'EORE780320'),
(13, 'GAZI820518'),
(14, 'SOQR711109'),
(15, 'AOZF650519'),
(16, 'OERF640704'),
(17, 'HESH830429'),
(18, 'FARF950205'),
(19, 'LORC760417'),
(20, 'MERV871227'),
(21, 'GAAP840701'),
(22, 'RAPC650423'),
(23, 'RAEA920223'),
(24, 'EAOH851112'),
(25, 'SACD800516'),
(26, 'GARB910425'),
(27, 'LOHI900507'),
(30, 'UAAA900222'),
(29, 'REGL860211'),
(31, 'MAGA960126'),
(32, 'VIPJ811117'),
(33, 'DITS740531'),
(34, 'ZAGJ810610'),
(35, 'EIBL770714'),
(36, 'GIVI870929'),
(37, 'VABI841002'),
(38, 'COOJ760223'),
(39, 'MAGB930629'),
(40, 'DAAL671010'),
(41, 'MEHJ730728'),
(42, 'COMJ810725'),
(43, 'LEAJ850509'),
(44, 'SAMA820730'),
(45, 'BEVC881112'),
(46, 'SAHI871217'),
(47, 'BOMR771122'),
(48, 'GOZI700514');
