<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Report
 * @author     Othon Parra Alcantar <othon.parra@adventa.mx>
 * @copyright  
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_report'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Report', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('ReportHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'report.php');

$controller = JControllerLegacy::getInstance('Report');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
