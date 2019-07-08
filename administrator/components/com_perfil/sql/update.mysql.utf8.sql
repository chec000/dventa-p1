/* Only premium users are allowed to update a component */

ALTER TABLE `#__core_user_info` ADD `phone` VARCHAR(12) NOT NULL AFTER `cellphone`,
ADD `street` VARCHAR(200) NOT NULL AFTER `phone`,
ADD `int_number` VARCHAR(11) NOT NULL AFTER `street`,
ADD `ext_number` VARCHAR(11) NOT NULL AFTER `int_number`,
ADD `reference` TEXT NOT NULL AFTER `ext_number`,
ADD `zip_code` VARCHAR(5) NOT NULL AFTER `reference`,
ADD `location` VARCHAR(200) NOT NULL AFTER `zip_code`,
ADD `city` VARCHAR(50) NOT NULL AFTER `location`,
ADD `state` VARCHAR(50) NOT NULL AFTER `city`,
ADD `rfc` VARCHAR(12) NOT NULL AFTER `state`,
ADD `nss` VARCHAR(12) NOT NULL AFTER `rfc`,
ADD `pid` VARCHAR(50) NOT NULL AFTER