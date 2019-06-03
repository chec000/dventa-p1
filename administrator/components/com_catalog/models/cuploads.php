<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class catalogModelcuploads extends JModelList
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
              'a.id', 'a.file_name', 'a.uploaded_at');
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
                        'a.id,a.file_name, a.uploaded_at'
                        )
                    );
        $query->from($db->quoteName('#__core_file_uploads').' AS a');     
        $query->where("a.file_type  = 'crols'");
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
    public function getTable($type = 'cuploads', $prefix = 'catalogTable', 
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
            $query->where('(a.file_name = '.$search.')');
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
