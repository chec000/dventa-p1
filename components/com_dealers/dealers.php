<?php
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Dealers');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
