<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Report
 * @author     Othon Parra Alcantar <othon.parra@adventa.mx>
 * @copyright  
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Report records.
 *
 * @since  1.6
 */
class ReportModelReportFields extends JModelList
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'field', 'a.`field`',
				'field_name', 'a.`field_name`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_report');
		$this->setState('params', $params);
		

		// List state information.
		parent::populateState('a.ordering', 'asc');
		$this->setState('list.limit',0);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}


	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__core_report_exchange_fields` AS a');

		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.field LIKE ' . $search . '  OR  a.field_name LIKE ' . $search . ' )');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();


		return $items;
	}

	public function getProfilesByUser(){

		$entry_byuser= (object) array();
		$users = $this->getUsers();
		foreach($users as $item){
			$user_id= $item->id;
			$profiles= $this->getUserProfiles($user_id);
			//foreach ($profiles as $pro){
				$entry_byuser->$user_id =$profiles;
			//}

		}

		return $entry_byuser;
	}

	public function getUsers(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		// Create a new query object.
		$query = $db->getQuery(true);
		
		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__users'));
		
		
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$result = $db->loadObjectList();

		return $result;
	}

	public function getUserProfiles($id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__user_profiles'));
		$query->where($db->quoteName('user_id') . ' = '. $db->quote($id));		
		$db->setQuery($query);
		$result = $db->loadObjectList();

		return $result;
	}

	public function getActiveFIelds(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__core_report_exchange_fields'));
		$query->where($db->quoteName('state') . ' = '. $db->quote('1'));
		$query->order('ordering ASC');		
		$db->setQuery($query);
		$result = $db->loadObjectList();

		return $result;
	}

	public function getOrderProducts(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		// Create a new query object.
		$query = $db->getQuery(true);
		
		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__core_order_products'));
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$result = $db->loadObjectList();

		return $result;
	}

	public function getCedisInfo($id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
			
		$query->select('*');
		$query->from($db->quoteName('#__core_cedis'));
		$query->where($db->quoteName('id') . ' = '. $db->quote(str_replace('"','',$id)));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if($result!=null){
			return $result[0];
		}else{
			return '0';
		}
		//$groupid = $result[0]->group_id;
		//consultar usergroups
		//return $result;
	}

	public function getOrderById($id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
		
		$query->select(array('a.created_at as fecha_canje, b.id as userid, b.block as block, b.name as nombre, b.username as username, b.email as email, c.cedis_id'));
		$query->from($db->quoteName('#__core_orders','a'));
		$query->join('left', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.user_id') . ' = ' . $db->quoteName('b.id') . ')');
		$query->join('LEFT', $db->quoteName('#__core_order_cedis', 'c') . ' ON (' . $db->quoteName('c.order_id') . ' = ' . $db->quote($id) . ')');
		$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));
		$db->setQuery($query);
		$result = $db->loadObjectList();

		if($result != null){
			return $result[0];
		}else{
			return '0';
		}
		
	}

	public function getUserCedis($id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
			
		$query->select('*');
		$query->from($db->quoteName('#__user_profiles'));
		$query->where($db->quoteName('user_id') . ' = '. $db->quote($id).' AND '.$db->quoteName('profile_key') . ' = '. $db->quote('profile.names_cedis'));
		$db->setQuery($query);
		$result = $db->loadObjectList();

		if($result!=null){
			return $result[0]->profile_value;
		}else
		{
			return '0';
		}
	}

	public function getCedisValue(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
			
		$query->select($db->quoteName('value'));
		$query->from($db->quoteName('#__core_configs'));
		$query->where($db->quoteName('key') . ' = '. $db->quote('checkout.delivery.mode'));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if($result != null){
			return $result[0]->value;				
		}else{
			return '0';
		}
	}

	public function getProfileByKey($id,$key){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__user_profiles'));
		$query->where($db->quoteName('user_id') . ' = '. $db->quote($id).' AND '.$db->quoteName('profile_key') . ' = '. $db->quote($key));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if($result!=null){
			return $result[0];			
		}
		
	}
}
