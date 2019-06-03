<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class catalogModelcproducts extends JModelList
{
    /**
     * 
     * @param type $config
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
          $config['filter_fields'] = array(
              'a.id', 'a.sku', 'a.title','a.description',
              'a.brand','a.file_name', 'a.price', 'likeF', 'dislikeF');
      }
      parent::__construct($config);
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
     * @return type
     */
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select(
            $this->getState(
                'list.select',
                'a.id,a.sku, a.title,' .
                'a.description, a.brand,' .
                'a.file_name, a.price,' .
                'SUM(IF(l.option = "like", 1,0)) as likeF, SUM(IF(l.option = "dislike", 1,0)) as dislikeF'
            )
        );
        $query->from($db->quoteName('core_products').' AS a');
        $query->join('LEFT', $db->quoteName('#__core_user_products_likes', 'l') . ' ON (' . 
            $db->quoteName('l.product_id') . ' = ' . 
            $db->quoteName('a.id') . ')');
        $query->where('a.editable = 1');        
        $query->group('a.id');
        $search = $this->setSearch($query,$db);
        $order = $this->setOrder($search, $db);        
        return $order;
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
                $query->where('(a.title LIKE '.$search.
                    ' OR a.sku LIKE '.$search.
                    ' OR a.description LIKE '.$search.')');
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