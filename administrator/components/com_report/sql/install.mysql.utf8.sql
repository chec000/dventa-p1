CREATE TABLE IF NOT EXISTS `#__core_report_user_fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `checked_out` int(11) DEFAULT NULL,
  `checked_out_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT IGNORE INTO `#__core_report_user_fields` (`id`, `field`, `field_name`, `ordering`, `state`, `checked_out`, `checked_out_time`) VALUES
(1, 'user', 'Nombre de usuario', 1, 1, 0, '2017-11-24 13:57:13'),
(2, 'name', 'Nombre completo', 2, 1, 0, '2017-11-24 13:57:13'),
(3, 'email', 'E-mail', 3, 1, 0, '2017-11-24 13:57:13'),
(4, 'status', 'Estatus de usuario', 4, 1, 0, '2017-11-24 13:57:13'),
(5, 'profile', 'Perfil', 5, 1, 0, '2017-11-24 13:57:13'),
(6, 'id_cedis', 'ID Cedis', 8, 1, 0, '2017-11-24 13:57:13'),
(7, 'cedis_name', 'Nombre de cedis', 9, 1, 0, '2017-11-24 13:57:13'),
(8, 'street', 'Calle', 10, 1, 0, '2017-11-24 13:57:13'),
(9, 'num_ext', 'Número exterior', 11, 1, 0, '2017-11-24 13:57:13'),
(10, 'num_int', 'Número interior', 12, 1, 0, '2017-11-24 13:57:13'),
(11, 'neighborhood', 'Colonia', 13, 1, 0, '2017-11-24 13:57:13'),
(12, 'reference', 'Referencia', 14, 1, 0, '2017-11-24 13:57:13'),
(13, 'city', 'Ciudad', 15, 1, 0, '2017-11-24 13:57:13'),
(14, 'estate', 'Estado', 16, 1, 0, '2017-11-24 13:57:13'),
(15, 'cp', 'CP', 17, 1, 0, '2017-11-24 13:57:13'),
(16, 'num_tel', 'Teléfono', 18, 1, 0, '2017-11-24 13:57:13'),
(17, 'num_cel', 'Celular', 19, 1, 0, '2017-11-24 13:57:13'),
(18, 'registry_date', 'Fecha de registro', 7, 1, 0, '2017-11-24 13:57:13'),
(19, 'last_name2', 'Apellido materno', 20, 1, 0, '2017-11-24 13:57:13'),
(20, 'last_name1', 'Apellido paterno', 21, 1, 0, '2017-11-24 13:57:13'),
(21, 'visits', 'Visitas', 22, 1, 0, '2017-11-24 13:57:13'),
(22, 'last_visit', 'Última visita', 6, 1, 0, '2017-11-24 13:57:13');



CREATE TABLE IF NOT EXISTS `#__core_report_exchange_fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `checked_out` int(11) DEFAULT '0',
  `checked_out_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT IGNORE INTO `#__core_report_exchange_fields` (`id`, `field`, `field_name`, `ordering`, `state`, `checked_out`, `checked_out_time`) VALUES
(1, 'no_canje', 'Número de canje', 1, 1, 0, '2017-11-30 11:04:49'),
(2, 'estatus_pedido', 'Estatus del pedido', 2, 1, 0, '0000-00-00 00:00:00'),
(3, 'fecha_canje', 'Fecha de canje', 3, 1, 0, '2017-11-30 11:04:49'),
(4, 'nombre_usuario', 'Nombre del usuario', 4, 1, 0, '2017-11-30 11:04:49'),
(5, 'username', 'Username', 5, 1, 0, '2017-11-30 11:04:49'),
(6, 'estatus_usuario', 'Estatus de usuario', 6, 1, 0, '2017-11-30 11:04:49'),
(7, 'codigo_pmr', 'Código PMR', 7, 1, 0, '2017-11-30 11:04:49'),
(8, 'codigo_cu', 'Código CU', 8, 1, 0, '2017-11-30 11:04:49'),
(9, 'descripcion_articulo', 'Descripción del articulo', 9, 1, 0, '2017-11-30 11:04:49'),
(10, 'cantidad', 'Cantidad', 10, 1, 0, '2017-11-30 11:04:49'),
(11, 'precio_unitario_puntos', 'Precio unitario(en puntos)', 11, 1, 0, '2017-11-30 11:04:49'),
(12, 'precio_unitario_pesos', 'Precio unitario(en pesos)', 12, 1, 0, '2017-11-30 11:04:49'),
(13, 'precio_total_pesos', 'Precio total(en pesos)', 13, 1, 0, '2017-11-30 11:04:49'),
(14, 'precio_total_puntos', 'Precio total(en puntos)', 14, 1, 0, '2017-11-30 11:04:49'),
(15, 'id_cedis', 'ID de cedis', 15, 1, 0, '2017-11-30 11:04:49'),
(16, 'cedis_name', 'Nombre de cedis', 16, 1, 0, '2017-11-30 11:04:49'),
(17, 'street', 'Calle', 17, 1, 0, '2017-11-30 11:04:49'),
(18, 'num_ext', 'Número exterior', 18, 1, 0, '2017-11-30 11:04:49'),
(19, 'num_int', 'Número interior', 19, 1, 0, '2017-11-30 11:04:49'),
(20, 'location', 'Colonia', 20, 1, 0, '2017-11-30 11:04:49'),
(21, 'reference', 'Referencia', 21, 1, 0, '2017-11-30 11:04:49'),
(22, 'city', 'Ciudad/Municipio', 22, 1, 0, '2017-11-30 11:04:49'),
(23, 'estate', 'Estado', 23, 1, 0, '2017-11-30 11:04:49'),
(24, 'zip_code', 'Código postal', 24, 1, 0, '2017-11-30 11:04:49'),
(25, 'telephone', 'Teléfono', 25, 1, 0, '2017-11-30 11:04:49'),
(26, 'cellphone', 'Celular', 26, 1, 0, '2017-11-30 11:04:49'),
(27, 'email', 'E-mail', 27, 1, 0, '2017-11-30 11:04:49');