<?php

class ModHelpDeskHelper
{
    /**
     * Retrieves the helpdesk message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getComponentId()
    {

    // Get a db connection.
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('value')));
    $query->from($db->quoteName('#__core_configs'));
    $query->where($db->quoteName('key') . ' = '. $db->quote('jira.components'));

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    // Load the results as a list of stdClass objects (see later for more options on retrieving data).
    $results = $db->loadObjectList();
    return $results;
    }
}