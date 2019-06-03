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

/**
 * Report helper.
 *
 * @since  1.6
 */
class ReportHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('Usuarios'),
			'index.php?option=com_report&view=userfields',
			$vName == 'userfields'
		);
		JHtmlSidebar::addEntry(
			JText::_('Canjes'),
			'index.php?option=com_report&view=reportfields',
			$vName == 'reportfields'
		);

	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_report';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	public static function getFieldsOrder(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select('*')
			->from('#__core_report_exchange_fields')
			->where('state = 1')
			->order('ordering ASC');

		$db->setQuery($query);
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$result = $db->loadObjectList();
		return $result;
	}

	public static function getUserFieldsOrder(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select('*')
			->from('#__core_report_user_fields')
			->where('state = 1')
			->order('ordering ASC');

		$db->setQuery($query);
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$result = $db->loadObjectList();
		return $result;
	}
}

