CREATE TABLE  IF NOT EXISTS `#__core_mecanicas` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `usergroup` INT(3) NOT NULL DEFAULT '18' ,
  `content` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL ,
  `state` TINYINT(3) NOT NULL DEFAULT '0' ,
  `publish_up` DATETIME NOT NULL ,
  `publish_down` DATETIME NOT NULL ,
  `ordering` INT(11) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
