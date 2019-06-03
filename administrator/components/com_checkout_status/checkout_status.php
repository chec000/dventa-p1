<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CHECKOUT_STATUS
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_checkout_status'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

$input = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Checkout_Status');
$controller->execute($input->getCmd('task'));
$controller->redirect();