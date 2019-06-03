<?php
defined('_JEXEC') or die;

class DealersModelDealers extends JModelList
{
  public function __construct($config = array())
  {

    if (empty($config['filter_fields']))
    {
      $config['filter_fields'] = array('id', 'a.id', 'cedis', 'a.cedis_id','state', 'a.state','names_cedis', 'a.names_cedis', 'create_at', 'a.create_at','ordering', 'a.ordering','a.publish_up','a.publish_down');
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

    parent::populateState('a.ordering', 'asc');
  }

  protected function getListQuery()
  {
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    $query->select(  $this->getState('list.select',
                                      'a.id, a.cedis_id, '.
                                      'a.state, a.names_cedis,'.
                                      'a.create_at, a.ordering, '.
                                      'a.street, a.publish_up,'.
                                      'a.city, a.publish_down'
                                      )
                                    );
    $query->from($db->quoteName('#__core_cedis').' AS a');

    //Checa el estado y ajusta la selección de nuestra BD en base al valor obtenido
    $published = $this->getState('filter.state');

    if (is_numeric($published))
    {
      $query->where('a.state = '.(int) $published);
    //Si no se seleccionó ningun estado mostramos todo
    } elseif ($published === '')
    {
      $query->where('(a.state IN (0, 1))');
    }

    // Filter by search in title
    $search = $this->getState('filter.search');
    if (!empty($search))
    {
      if (stripos($search, 'id:') === 0)
      {
        $query->where('a.id = '.(int) substr($search, 3));
      } else {
        $search = $db->Quote('%'.$db->escape($search, true).'%');
        $query->where('(a.names_cedis LIKE '.$search.' OR a.cedis_id LIKE '.$search.')');
      }
    }

    // Add the list ordering clause.
    $orderCol = $this->state->get('list.ordering');
    $orderDirn = $this->state->get('list.direction');
    if ($orderCol == 'a.ordering')
    {
      $orderCol = 'a.cedis_id '.$orderDirn.', a.ordering';
    }
    $query->order($db->escape($orderCol.' '.$orderDirn));

    return $query;
  }
}
