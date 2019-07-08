<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Pass_recovery records.
 *
 * @since  1.6
 */
class PerfilModelPerfiles extends JModelList
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
                'id', 'u.`id`',
                'name', 'u.`name`',
                'username', 'u.`username`',
                'cellphone', 'i.`cellphone`',
                'phone', 'i.`phone`',
                'status','i.complete_data'

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

        $status = $app->getUserStateFromRequest($this->context . '.filter.status', 'type_filter', '', 'string');
        $this->setState('filter.status', $status);


        // Load the parameters.
        $params = JComponentHelper::getParams('com_perfil');

        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
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
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */


    public  function updateStatus($userId,$status){
        try{


            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('i.user_id')
                ->from($db->quoteName('#__core_user_info', 'i'))
                ->where($db->quoteName('i.user_id') . ' = ' . $db->quote($userId));
            $db->setQuery($query);
            $result = $db->loadObject();
            if($result!=null){
            $date= new DateTime();
            $db = JFactory::getDbo();
            $fields = array(              
                $db->quoteName('complete_data') . '=' . $db->quote($status),
                     );
            $query = $db->getQuery(true);
            $conditions = array(
                $db->quoteName('user_id') . ' = ' . $db->quote($userId),
            );
            $query->update($db->quoteName('#__core_user_info'))
                ->set($fields)
                ->where($conditions);
            $db->setQuery($query);
              $result=$db->execute();
    
             echo  json_encode(array("result"=>$result,
                "code"=>200
         ));
            }else{
        
             echo  json_encode(array("result"=>false,
                "code"=>500
                ));

            }

        }catch(Exception $e){
        var_dump($e);
        }


    }

    public function getUsuarioId($userId){
        try{
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            // Get the database object and a new query object.
            $query->select('u.*')
                ->from($db->quoteName('#__core_user_info','u'))
                ->where('u.user_id  = ' . $db->quote($userId));
            // Set and query the database.
            $db->setQuery($query);

            return  $db->loadObject();
        }catch (Exception $e){
            return null;
        }

    }

    public function getListQuery()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array(
            $db->quoteName('u.email'),
            $db->quoteName('u.id'),
            $db->quoteName('u.name'),
            $db->quoteName('u.username'),
            $db->quoteName('u.email'),
            $db->quoteName('i.cellphone'),
            $db->quoteName('i.complete_data'),

        ))
            ->from($db->quoteName('#__users', 'u'))
            ->join('LEFT', $db->quoteName('#__core_user_info', 'i') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('i.user_id') . ')');

        $search = $this->setSearch($query,$db);
        $status=$this->getFilterStatus($search,$db);


        return $status;

    }
private  function getFilterStatus(&$query,&$db){
    $status = $this->getState('filter.status');

        if (!empty($status)){

            if($status=='activo'){

                $query->where('(i.complete_data= 1)');

            }else{
                $query->where('(i.complete_data= 0)');

            }
        }
        return $query;


}

    private function setSearch(&$query,&$db)
    {
        // Filter by search in title
        $search = $this->getState('filter.search');

        if (!empty($search))
        {

            if (stripos($search, 'phone:') === 0||stripos($search, 'cellphone:') === 0)
            {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(i.cellphone LIKE '.$search.' OR i.phone LIKE '.$search.')');
            } else if(stripos($search, 'name:') === 0){

                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(u.name LIKE '.$search.' OR u.username LIKE '.$search.')');

            }else{
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(u.email LIKE '.$search.')');
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
