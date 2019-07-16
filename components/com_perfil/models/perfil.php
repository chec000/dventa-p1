<?php

defined('_JEXEC') or die;

class PerfilModelPerfil extends JModelAdmin {

    protected $text_prefix = 'COM_PERFIL';
    protected $data;
    public $file_name;

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

                foreach ($data as $key => $v) {
        
        
                    $p=$v['name'];
                     $value=$v['value'];        
                    if($p!='TERM'&&$p!="password2" && $p!='email'&&$p!='name'&&$p!='username'&&$p!='password'&&$p!='car'){
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
                    
                 return   $db->execute();
                    
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
           var_dump($e->getMessage());
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

    public function getForm($data = array(), $loadData = true) {

        $form = $this->loadForm('com_perfil.perfiles', 'perfil', array('control' => 'jform', 'load_data' => $loadData));


        if (empty($form)) {
            return false;
            }
        return $form;
    }

    public function getData() {

        $user = JFactory::getUser();
        $userId = $user->get('id');
        $this->data = new JUser($userId);
        if ($userId > 0) {
            // Load the profile data from the database.
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select(array(
                        $db->quoteName('u.email'),
                        $db->quoteName('u.name'),
                        $db->quoteName('u.password'),
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

    public  function updateStatus($userId){
        try{

            $db = JFactory::getDbo();
            $fields = array(
                //$db->quoteName('name') . '=' . $db->quote($data['name']),
                $db->quoteName('complete_data') . '=' . $db->quote('0'),

            );
            $query = $db->getQuery(true);
            // Conditions for which records should be updated.
            $conditions = array(
                $db->quoteName('user_id') . ' = ' . $db->quote($userId),
            );
            $query->update($db->quoteName('#__core_user_info'))
                ->set($fields)
                ->where($conditions);
            $db->setQuery($query);
            return $db->execute();
        }catch(Exception $e){

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

}
