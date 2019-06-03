<?php
/**
 * @copyright	@copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$class_sfx = htmlspecialchars($params->get('class_sfx'));

$user = JFactory::getUser();
$points = modUserpointsHelper::getAvailablePoints();
$coin= modUserpointsHelper::coinName();

require(JModuleHelper::getLayoutPath('mod_userpoints', $params->get('layout', 'default')));
