<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Layoutpoint
 * @author     EDGAR <edgarmaster89@hotmail.com>
 * @copyright  2017 EDGAR
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_layoutpoint'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Layoutpoint', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('LayoutpointHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'layoutpoint.php');

$controller = JControllerLegacy::getInstance('Layoutpoint');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
