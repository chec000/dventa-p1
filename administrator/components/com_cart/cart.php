<?php
/**
 * @version    1.0.0
 * @package    COM_CART
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_cart'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

$controller = JControllerLegacy::getInstance('Cart');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();