<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_wishlist'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

$input = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Wishlist');
$controller->execute($input->getCmd('task'));
$controller->redirect();