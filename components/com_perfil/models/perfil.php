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
        $db = JFactory::getDbo();
        // Fields to update.
        $fields = array(
            $db->quoteName('name') . '=' . $db->quote($data['name']),
            $db->quoteName('email') . '=' . $db->quote($data['email'])
        );
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
                $date = new DateTime();

                $fields = array();


                foreach ($data as $p => $value) {
                    if($p!='TERM' && $p!='email'){
                        array_push($fields, $db->quoteName($p) . '=' . $db->quote($value));

                    }
                }

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
            } else {
                $db = JFactory::getDbo();
                //try {

               $columns=array(
                   'user_id'

               );
                $values = array($userId);

                foreach ($data as $p => $value) {
                    if($p!='TERM' && $p!='email'){
                        array_push($columns, $p );
                        array_push($values, $value );
                    }
                }

           $query = $db->getQuery(true);
                $query
                        ->insert($db->quoteName('#__core_user_info'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                $db->setQuery($query);
                $db->execute();
                return true;
            }
            //$this->updateCedis($userId, $data['cedis']);
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

    public function getForm($data = array(), $loadData = true) {

        $form = $this->loadForm('com_perfil.perfiles', 'perfil', array('control' => 'jform', 'load_data' => $loadData));


        if (empty($form)) {
            return false;
            }
        return $form;
    }

    public function getData() {

        //$dashboardID = $params->get('dashboardID');

        $user = JFactory::getUser();
        $userId = $user->get('id');
        $this->data = new JUser($userId);
        if ($userId > 0) {
            // Load the profile data from the database.
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select(array(
                        $db->quoteName('u.email'),
                        $db->quoteName('i.user_id'),
                        $db->quoteName('u.name'),
                        $db->quoteName('i.cellphone'),
                        $db->quoteName('i.phone'),
                        $db->quoteName('i.street'),
                        $db->quoteName('i.int_number'),
                        $db->quoteName('i.ext_number'),
                        $db->quoteName('i.reference'),
                        $db->quoteName('i.zip_code'),
                        $db->quoteName('i.location'),
                        $db->quoteName('i.city'),
                        $db->quoteName('i.state'),
                        $db->quoteName('i.rfc'),
                        $db->quoteName('i.nss'),
                        $db->quoteName('i.pid'),
                        $db->quoteName('i.gmin'),

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


/*
 *
 *
 *
 *                 $fields = array(
                   //$db->quoteName('name') . '=' . $db->quote($data['name']),
                    $db->quoteName('cellphone') . '=' . $db->quote($data['cellphone']),
                    $db->quoteName('phone') . '=' . $db->quote($data['phone']),
                    $db->quoteName('street') . '=' . $db->quote($data['street']),
                    $db->quoteName('int_number') . '=' . $db->quote($data['int_number']),
                    $db->quoteName('ext_number') . '=' . $db->quote($data['ext_number']),
                    $db->quoteName('reference') . '=' . $db->quote($data['reference']),
                    $db->quoteName('zip_code') . '=' . $db->quote($data['zip_code']),
                    $db->quoteName('location') . '=' . $db->quote($data['location']),
                    $db->quoteName('city') . '=' . $db->quote($data['city']),
                    $db->quoteName('state') . '=' . $db->quote($data['state']),
                    $db->quoteName('rfc') . '=' . $db->quote($data['rfc']),
                    $db->quoteName('nss') . '=' . $db->quote($data['nss']),
                    $db->quoteName('pid') . '=' . $db->quote($data['pid']),
                    $db->quoteName('gmin') . '=' . $db->quote($data['gmin']),

                    $db->quoteName('complete_data') . '=' . $db->quote('1'),
                    $db->quoteName('complete_data_at') . '=' . $db->quote($date->format('Y-m-d H:i:s')),

                );

                $columns = array(
                    'user_id',
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
                    'complete_data',
                );

                $values = array(
                    $db->quote($userId),
                    $db->quote($data['cellphone']),
                    $db->quote($data['phone']),
                    $db->quote($data['street']),
                    $db->quote($data['int_number']),
                    $db->quote($data['ext_number']),
                    $db->quote($data['reference']),
                    $db->quote($data['zip_code']),
                    $db->quote($data['cellphone']),
                    $db->quote($data['city']),
                    $db->quote($data['state']),
                    $db->quote($data['rfc']),
                    $db->quote($data['nss']),
                    $db->quote($data['pid']),
                     $db->quote($data['gmin']),
                    $db->quote('1'),
                );
 *
 *
 * */