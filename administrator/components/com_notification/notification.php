<?php
/**
 * @version    1.0.0
 * @package    COM_NOTIFICATION
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_notification'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::registerPrefix('Notification', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('NotificationHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'notification.php');

$controller = JControllerLegacy::getInstance('Notification');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
