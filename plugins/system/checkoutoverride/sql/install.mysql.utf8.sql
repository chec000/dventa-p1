DROP TABLE IF EXISTS #__core_order_mobile_money ;
CREATE TABLE #__core_order_mobile_money (
  id int(10) UNSIGNED NOT NULL,
  order_id int(10) UNSIGNED NOT NULL,
  user_id int(10) UNSIGNED NOT NULL,
  name varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  lastname varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  secondlastname varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  email varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  rfc varchar(13) COLLATE utf8_spanish2_ci NOT NULL,
  birthday varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  cellphone varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  company varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

ALTER TABLE #__core_order_mobile_money
  ADD PRIMARY KEY (id);
ALTER TABLE #__core_order_mobile_money
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

