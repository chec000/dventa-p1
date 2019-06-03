<?php
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Checkout');
$controller->execute($input->getCmd('task'));
$controller->redirect();