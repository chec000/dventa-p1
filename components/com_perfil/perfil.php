<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Perfil');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
