<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CART
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CartModelSuploads extends JModelList
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
              'a.id', 'a.file_name', 'a.uploaded_at', 'a.description', 'u.username');
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
                'a.id,a.file_name, a.uploaded_at, a.description, u.username'
            )
        );
        $query->from($db->quoteName('#__core_file_uploads').' AS a');   
        $query->join('INNER', $db->quoteName('#__users', 'u') . ' ON (' . 
            $db->quoteName('u.id') . ' = ' . 
            $db->quoteName('a.user_id') . ')');  
        $query->where("a.file_type  = 'stock.upload'");
        $search = $this->setSearch($query,$db);
        $order = $this->setOrder($search, $db);        
        return $order;       
    }
    
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'suploads', $prefix = 'cartTable', 
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
        $search = $this->getUserStateFromRequest(
            $this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
        $published = $this->getUserStateFromRequest($this->context.
            '.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $published);
        parent::populateState('a.ordering', 'asc');
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
                $query->where('a.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('( a.id LIKE ' . $search . '  OR  a.file_name LIKE ' . $search . '  OR  a.description LIKE ' . $search . ' OR  u.username LIKE '. $search .')');
            }
        }
        return $query;        
    }
    
    /**
     * 
     * @param type $query
     * @param type $db
     * @return type
     */
    private function setOrder(&$query,&$db)
    {
        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol === 'a.ordering'|| is_null($orderCol))
        {
          $orderCol = 'a.id';
      }
      $query->order($db->escape($orderCol.' '.$orderDirn)); 
      return $query;
  }     
}