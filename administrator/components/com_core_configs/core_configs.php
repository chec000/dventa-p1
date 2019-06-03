<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Core_configs
 * @author     Adventa <>
 * @copyright  Adventa (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_core_configs'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Core_configs', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Core_configsHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'core_configs.php');

$controller = JControllerLegacy::getInstance('Core_configs');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
