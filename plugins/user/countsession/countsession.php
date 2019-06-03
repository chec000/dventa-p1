<?php
/**
 * @copyright	Copyright (c) 2017 countsession. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * user - countsession Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	countsession.countsession
 */
class plgusercountsession extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}

	function onUserAfterLogin($options) {
		
        // Get a db connection.
		$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

				// Select all records from the user profile table where key begins with "custom.".
				// Order it by the ordering field.
				$query->select($db->quoteName(array('count_session',)));
				$query->from($db->quoteName('#__core_countuser'));
				$query->where($db->quoteName('user_id') . ' = '. $db->quote($options['user']->id));


				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Load the results as a list of stdClass objects (see later for more options on retrieving data).
				$results = $db->loadObject();
				$count=(int)$results->count_session;
				$count=$count+1;
				//var_dump($results); die();
				if($results === NULL){
					/*****Inserta*****/

					// Create a new query object.
					$query_insert = $db->getQuery(true);

						// Insert columns.
						$columns = array('user_id','count_session');

						// Insert values.
						$values = array($db->quote($options['user']->id), 1);

							// Prepare the insert query.
							$query_insert
    						->insert($db->quoteName('#__core_countuser'))
    						->columns($db->quoteName($columns))
    						->values(implode(',', $values));

						// Set the query using our newly populated query object and execute it.
						$db->setQuery($query_insert);
						$db->execute();
					
				}else{
					/*****Actualiza*****/

					// Create a new query object.
					$query_update = $db->getQuery(true);

					// Fields to update.
					$fields = array(
    				$db->quoteName('count_session') . ' = ' . $db->quote($count));

    					// Conditions for which records should be updated.
						$conditions = array(
    					$db->quoteName('user_id') . ' = '. $db->quote($options['user']->id));

    					$query_update->update($db->quoteName('#__core_countuser'))->set($fields)->where($conditions);
    					$db->setQuery($query_update);

					$result = $db->execute();
		
				}
    }
	
}