<?php
defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/WishlistHelper.php';

$componentConfig = WishlistHelper::getComponentParams('com_wishlist', 'wishlist_enable');

if ($componentConfig != '1')
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

$input = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Wishlist');
$controller->execute($input->getCmd('task'));
$controller->redirect();