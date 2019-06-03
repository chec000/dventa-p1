<?php
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Mecanicas');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
