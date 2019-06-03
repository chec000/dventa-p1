<?php
/**
 * @copyright	@copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$class_sfx = htmlspecialchars($params->get('class_sfx'));


$user = JFactory::getUser();
$exchanged = modAccount_statusHelper::getExchanged();
$adquired = modAccount_statusHelper::getAdquired();
$actual = modAccount_statusHelper::getActual();
//Obtener el nombre de la moneda, se almacena en core_configs con el valor pmr.coin
$coin = modAccount_statusHelper::getCoinName();



require(JModuleHelper::getLayoutPath('mod_account_status', $params->get('layout', 'default')));
