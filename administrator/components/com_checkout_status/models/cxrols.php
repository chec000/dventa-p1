<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout_status
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class Checkout_StatusModelCxrols extends JModelList
{
    /**
     * 
     * @param string $config
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
          $config['filter_fields'] = array(
              'c.id','checkoutStatus','c.start_date','c.end_date','c.created_at','c.updated_at','rolid','rol');
      }
      parent::__construct($config);
  }  

    /**
     * 
     * @return type
     */
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select(
            $this->getState(
                'list.select',
                'c.id,' .
                'false as checkoutStatus,' .
                'c.start_date,c.end_date,' .
                'r.id as rolid,r.title as rol,'.
                'c.created_at,c.updated_at'
            )
        );
        $query->from($db->quoteName('#__core_checkout_x_roles').' AS c');
        $query->join('INNER', $db->quoteName('#__usergroups', 'r') . ' ON (' . 
            $db->quoteName('r.id') . ' = ' . 
            $db->quoteName('c.rol_id') . ')');
        $search = $this->setSearch($query,$db);
        return $search;       
    }

    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'cxrol', $prefix = 'Checkout_StatusTable', 
        $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * 
     * @param type $ordering
     * @param type $direction
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
        $params = JComponentHelper::getParams('com_checkout_status');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }
    
    /**
     * 
     * @param type $query
     * @param type $db
     * @return type
     */
    private function setSearch(&$query,&$db)
    {
        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
          if (stripos($search, 'id:') === 0)
              {
                $query->where('c.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(c.id = '.$search.
                    ' OR r.title = '.$search.')');
            }
        }
        return $query;        
    }
}