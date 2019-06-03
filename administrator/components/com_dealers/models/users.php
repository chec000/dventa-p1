<?php
defined('_JEXEC') or die;

class DealersModelUsers extends JModelList
{
  public function __construct($config = array())
  {

    if (empty($config['filter_fields']))
    {
      $config['filter_fields'] = array('u.name','u.username','mapid','map.id','c.names_cedis','map.cedis_id','map.state');
    }

    parent::__construct($config);

  }

  // populateState Ajusta la columna por default que será la designada para el ordenamiento en la vista
  protected function populateState($ordering = null, $direction = null)
  {

    //Checamos lo que ha escrito el usuario en la caja de búsqueda y lo asignamos al filtro {filter.search} el cual se usará en nuestra query
    $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
    $this->setState('filter.search', $search);

    //Checamos qué opción del filtro Status está seleccionado y lo asignamos a una variable que usaremos en nuestra Query
    $published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
    $this->setState('filter.state', $published);

    parent::populateState('u.id', 'asc');
  }

  protected function getListQuery()
  {
    $db = $this->getDbo();
    $query = $db->getQuery(true)
                ->select(  $this->getState('list.select',
                                      'u.name, u.username,'.
                                      'map.cedisid, c.names_cedis,'.
                                      'map.id AS mapid, map.state'
                                      )
                                    )
                ->from($db->quoteName('#__users').' AS u')
                ->join('INNER', $db->quoteName('#__core_users_cedis_map').' AS map ON u.id = map.userid')
                ->join('INNER', $db->quoteName('#__core_cedis').' AS c ON map.cedisid = c.cedis_id');

    //Checa el estado y ajusta la selección de nuestra BD en base al valor obtenido
    $published = $this->getState('filter.state');

    if (is_numeric($published))
    {
      $query->where('map.state = '.(int) $published);
    //Si no se seleccionó ningun estado mostramos todo
    } elseif ($published === '')
    {
      $query->where('(map.state IN (0, 1))');
    }

    // Filter by search in title
    $search = $this->getState('filter.search');
    if (!empty($search))
    {
      if (stripos($search, 'id:') === 0)
      {
        $query->where('u.id = '.(int) substr($search, 3));
      } else {
        $search = $db->Quote('%'.$db->escape($search, true).'%');
        $query->where('(u.name LIKE '.$search.' OR c.names_cedis LIKE '.$search.')');
      }
    }

    // Add the list ordering clause.
    $orderCol = $this->state->get('list.ordering');
    $orderDirn = $this->state->get('list.direction');
    if ($orderCol == 'a.id')
    {
      $orderCol = 'u.name '.$orderDirn.', u.id';
    }
    $query->order($db->escape($orderCol.' '.$orderDirn));

    return $query;
  }
}
