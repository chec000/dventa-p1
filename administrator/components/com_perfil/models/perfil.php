<?php
/**
 * @version    1.0.0
 * @package    com_catalog
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license
 */

// No direct access.
defined('_JEXEC') or die;

/**
 *
 *
 * @since  1.6
 */
class PerfilModelPerfil extends JModelAdmin
{
    /**
     * @var      string    The prefix to use with controller messages.
     * @since    1.6
     */
    protected $text_prefix = 'com_perfil';

    protected $data;
    public $file_name;


    /**
     * @var   	string  	Alias to manage history control
     * @since   3.2
     */

    /**
     * @var null  Item data
     * @since  1.6
     */
    protected $item = null;

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return    JTable    A database object
     *
     * @since    1.6
     */
    public function getTable($type = 'Cproduct', $prefix = 'CatalogTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      An optional array of data for the form to interogate.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  JForm  A JForm object on success, false on failure
     *
     * @since    1.6
     */

    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.

        $form = $this->loadForm('com_perfil.perfil', 'perfil',array('control' => 'jform','load_data' => $loadData)/* $options = array('control' => 'jform')*/);
        if (empty($form)) {
            return false;
        }

        return $form;
    }




    /**
     * Method to get the data that should be injected in the form.
     *
     * @return   mixed  The data for the form.
     *
     * @since    1.6
     */

    /**
     * Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  mixed    Object on success, false on failure.
     *
     * @since    1.6
     */


    /**
     * PerfilModelPerfil::updateUser()
     * @param type $data
     * @param type $userId
     */
    public function updateUser($data, $userId) {

        if(count($data)>0){
            $db = JFactory::getDbo();
            // Fields to update.
            $fields=array();
            foreach ($data as $key=>$value){
                array_push($fields,$db->quoteName($key) . '=' . $db->quote($value));
            }

            $query = $db->getQuery(true);
            $conditions = array(
                $db->quoteName('id') . ' = ' . $db->quote($userId),
            );


            $query->update($db->quoteName('#__users'))
                ->set($fields)
                ->where($conditions);
            $db->setQuery($query);
            return $db->execute();

        }

    }

    /**
     * PerfilModelPerfil::updateData()
     * @param type $data
     * @param type $userId
     * @param type $jinput
     * @return boolean
     */
    public function updateData($data, $userId, $jinput) {



        try {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('i.user_id')
                ->from($db->quoteName('#__core_user_info', 'i'))
                ->where($db->quoteName('i.user_id') . ' = ' . $db->quote($userId));
            $db->setQuery($query);
            $results = $db->loadObject();

            if ($results !== null) {
                // Fields to update.
                $fields = array();
               $no_car_data=false;

                foreach ($data as $p => $value) {
                    if($p!='TERM' && $p!='email'&&$p!='name'&&$p!='username'&&$p!='password'&&$p!='car'){
                        array_push($fields, $db->quoteName($p) . '=' . $db->quote($value));
                    }
                    if($p=="car_nodata"){
                     $no_car_data=true;       
                    }

                }
                if(!$no_car_data){
                    $f=0;
                       array_push($fields, $db->quoteName('car_nodata') . '='.  $f);
                }


                if (count($fields)>0){
                    $query = $db->getQuery(true);
                    // Conditions for which records should be updated.
                    $conditions = array(
                        $db->quoteName('user_id') . ' = ' . $db->quote($userId),
                    );

            
                    $query->update($db->quoteName('#__core_user_info'))
                        ->set($fields)
                        ->where($conditions);
                    $db->setQuery($query);
                    $db->execute();
                }
            } else {
                $db = JFactory::getDbo();
                //try {

                $columns=array(
                    'id',
                    'user_id',
                    'state_id'
                );
                $values = array($db->quote(null),$db->quote($userId),$db->quote(2));
                $campos=[
                    'user_id',
                    'state_id',
                    'branch_office',
                    'cellphone',
                    'phone',
                    'street',
                    'int_number',
                    'ext_number',
                    'reference',
                    'zip_code',
                    'location',
                    'city',
                    'state',
                    'rfc',
                    'nss',
                    'pid',
                    'gmin',
                    'distributor',
                    'dob',
                    'complete_data',
                    'complete_data_at'
                ];
                    foreach ($data as $p => $value) {
                    if($p!='TERM' && $p!='email'&&$p!='name'&&$p!='username'&&$p!='password'&&$p!='car'){
                        array_push($values, $db->quote($value ));
                        array_push($columns,$p);
                    }
                }
                foreach ($campos as $p => $v) {
                    if (!in_array($v, $columns)) {
                        array_push($columns,$v);
                        array_push($values, $db->quote('' ));
                    }
                }
                $query = $db->getQuery(true);
                $query
                    ->insert($db->quoteName('#__core_user_info'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',',$values));
                $db->setQuery($query);
                $db->execute();
                return true;
            }
        } catch (Exception $e) {
            $this->setError($e);
            return false;
        }

        return true;
    }


    public  function  getParams(){

        $params = JComponentHelper::getParams('com_perfil');

        $param = $params->toArray();
        if (count($param)>0){
            return $param;
        }else{

            return false;
        }

    }


    public function getData() {

        $jinput = JFactory::getApplication()->input;
        $userId     = $jinput->get('id', 1, 'INT');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('u.id')
            ->from($db->quoteName('#__users', 'u'))
            ->where($db->quoteName('u.id') . ' = ' . $userId);
        $db->setQuery($query);
        $userOBJ = $db->loadObject();

        $this->data = new JUser($userOBJ->id);
        if ($userId > 0) {
            // Load the profile data from the database.
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select(array(
                $db->quoteName('u.name'),
                $db->quoteName('u.password'),
                $db->quoteName('u.email'),
                'i.*',
            ))
                ->from($db->quoteName('#__users', 'u'))
                ->join('LEFT', $db->quoteName('#__core_user_info', 'i') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('i.user_id') . ')')
                ->where($db->quoteName('u.id') . ' = ' . $db->quote($userId));
            $db->setQuery($query);
            try {
                $results = $db->loadObject();

            } catch (RuntimeException $e) {
                die($e->getMessage());
                $this->_subject->setError($e->getMessage());
                return false;
            }
            if($results!=null){
                foreach ($results as $key => $value) {
                    $this->data->$key = $value;
                }
            }

        }

        return $this->data;
    }

    protected function loadFormData() {

        $data = $this->getData();
        $this->preprocessData('com_perfil.perfiles', $data, 'perfiles');

        return $data;
    }


    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk))
        {

        }

        return $item;
    }

}