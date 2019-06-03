<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CheckoutModelNotification extends JModelLegacy
{
	protected $notificationContentTable = '#__notification_content';

	public function getTemplae($key){
		$results = array();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
		->select(array('c.id, c.key, c.value'))
		->from($db->quoteName($this->notificationContentTable, 'c'))
		->where('c.key = ' . $db->Quote($key))
		->where('c.visibility = 1')
		->order($db->quoteName('c.key') . ' ASC');

		$db->setQuery($query);

		$results = $db->loadObject();

		return $results;
	}
}