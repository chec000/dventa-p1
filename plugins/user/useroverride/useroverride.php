<?php

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

class plgUserUserOverride extends JPlugin {

    public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);


    }

    public function onContentPrepareData($context, $data) {

        // Check we are manipulating a valid form.
        if (!in_array($context, array('com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile'))) {
            return true;
        }

        if (is_object($data)) {
            $userId = isset($data->id) ? $data->id : 0;
       
            if (!isset($data->profile) && $userId > 0) {
                
                // Load the profile data from the database.
                $db = JFactory::getDbo();

                $query = $db->getQuery(true);
                $query
                        ->select(
                                $db->quoteName('u.email') . ',' .
                                $db->quoteName('i.last_name1') . ',' .
                                $db->quoteName('i.last_name2') . ',' .
                                $db->quoteName('i.business_name') . ',' .
                                $db->quoteName('i.user_id') . ',' .
                                $db->quoteName('u.name') . ',' .
                                $db->quoteName('i.cellphone')
                        )
                        ->from($db->quoteName('#__core_user_info', 'i'))
                        ->join('LEFT', $db->quoteName('#__users', 'u') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('i.user_id') . ')')
                        ->where($db->quoteName('i.user_id') . ' = ' . $db->quote($userId));

                $db->setQuery($query);
                //echo $query->__toString();
                    
                try {
                    $results = $db->loadObject();
                } catch (RuntimeException $e) {
                    $this->_subject->setError($e->getMessage());

                    return false;
                }

                if($results!=false){
                    foreach ($results as $key => $value) {
                        $data->$key = $value;
                    }
                }

            }else{

            }
        }
    }

    public function onBeforeRender() {
        $app = JFactory::getApplication();
        
        if ($app->isAdmin()) {
            return true;
        }

        if ($app->input->get('option', '') != 'com_users') {
            return true;
        }

        if ($app->input->get('view', '') != 'registration') {
            return true;
        }

        JText::script('PLG_USEROVERRIDE_ERROR_DATA');
        JText::script('PLG_USEROVERRIDE_FIELD_PROFILE_MSG');
        JText::script('PLG_USEROVERRIDE_NOTMATCH_FIELD');
        JText::script('COM_USERS_REGISTER_PID_DESC');
        JText::script('COM_USERS_REGISTER_GMIN_DESC');
        JText::script('PLG_USER_REGISTER_NAMEERROR');
        JText::script('PLG_USER_REGISTER_PASSWORD');
        JText::script('PLG_USERS_REGISTER_USERNAME_INVALID');
        JText::script('PLG_USERS_TERM_COND');
        JText::script('PLG_USERS_PRI');
        JText::script('PLG_USERS_REGISTER_CELLPHONE_ERROR');
        JText::script('PLG_USERS_REGISTER_EMAIL1_ERROR');
        JText::script('PLG_USERS_REGISTER_LASTNAME2_ERROR');
        JText::script('PLG_USERS_REGISTER_LASTNAME1_ERROR');
        JText::script('PLG_USERS_REGISTER_NAME_ERROR');
        JText::script('PLG_USERS_REGISTER_PIN1_ERROR');    
        JText::script('PLG_USERS_REGISTER_PIN_ERROR');
        
        





        JHtml::stylesheet('plugins/' . $this->_type . '/' . $this->_name . '/assets/css/sweetalert2.min.css');
        JHtml::script('plugins/' . $this->_type . '/' . $this->_name . '/assets/js/sweetalert2.min.js');
        JHtml::stylesheet('plugins/' . $this->_type . '/' . $this->_name . '/assets/css/custom.css');

        $document = JFactory::getDocument();
        $document->addScript('plugins/' . $this->_type . '/' . $this->_name . '/assets/js/validation.js?t=' . time());


        return true;
    }

    public function onContentPrepareForm($form, $data) {

        $app = JFactory::getApplication();

        if (!($form instanceof JForm)) {
            $this->_subject->setError('JERROR_NOT_A_FORM');


            return false;
        }

        // Check we are manipulating a valid form.
        $name = $form->getName();

        if (!in_array($name, array('com_users.user', 'com_users.profile', 'com_users.registration'))) {
            return true;
        }

        //Resetear el XML del core
        if (!$app->isAdmin()) {

            $form->reset(true);
            // Add the registration fields to the form.
            JForm::addFormPath(__DIR__ . '/forms');

            if ($name == 'com_users.registration') {

                $form->loadFile('registration');
            
                $fields = array(
                    'name',
                    'email',
                    'telephone',
                    'last_name1',
                    'last_name2',
                    'business_name',
                    'cellphone',
                    'password',
                );
            
            }

            if ($name == 'com_users.profile') {
                $form->loadFile('profile');
                $fields = array(
                    'name',
                    'estado',
                    'sucursal',
                    'telephone',
                    'cellphone',
                    'last_name1',
                    'last_name2',
                    'business_name',

                );
            }
        }



        return true;
    }

    public function onUserBeforeSave($user, $isnew, $data) {
        //Funcionalidad BlackList, bloquea al usuario y envía notificación            
       
            $db = JFactory::getDbo();
            $app = JFactory::getApplication();
            $form = $app->input->get('jform', array(), 'ARRAY');

                $recipients =array($form['email1']);
                    

                $emailBody = JText::sprintf(
                                'PLG_USERS_REGISTER_CELLPHONE_ERROR', $form['name'], $form['username'], $form['email1'], $data['cellphone'], 2, $_SERVER['REMOTE_ADDR']
                );

                $response = self::sendMail($recipients, JText::_('PLG_USERS_REGISTER_CELLPHONE_ERROR') . ' (' . $form['username'] . ')', $emailBody);

                $app->enqueueMessage(JText::_('PLG_USERS_REGISTER_CELLPHONE_ERROR'), 'warning');

                return $response;
         
        
    }


    protected function sendMail($recipient, $subject, $body) {
            try {
        $config = JFactory::getConfig();

        $recipient = explode(',', trim($recipient));
     
            $send = JFactory::getMailer()->sendMail($config->get('mailfrom'), $config->get('fromname'), $recipient, $subject, $body, true);
        return $send;    

            } catch (Exception $e) {
               var_dump($e->getMessage()); 
            }

    }



    public function onUserAfterSave($data, $isNew, $result, $error) {
        $jinput = JFactory::getApplication()->input;    
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $option = $app->input->get('view', '');
        $userId = ArrayHelper::getValue($data, 'id', 0, 'int');

        $this->updateUser($data,$userId);

    }



        private function getFiels(){
        $db = JFactory::getDBO();
        $sql = "SHOW COLUMNS FROM #__core_user_info";
        $db->setQuery($sql);  
         return $fields = $db->loadObjectList();

        }

    private function updateUser($data,$id){

        try {
            $db = JFactory::getDbo();
            $columns = array();            

            $fields=$this->getFiels();
            foreach ($fields as $key => $value) {
                    array_push($columns, $value->Field);    
            }
            $userId=$id;
            $values = array();

            foreach ($columns as $key => $value) {                  
                    switch ($value) {
                        case 'user_id':
                    array_push($values,$userId);         
                        break;
                        case 'state_id':
                    array_push($values,$data['state']);
                        break;
                        case 'branch_office':
                    array_push($values, $db->quote($data['office']));
                        break;
            
                        case 'last_name1':
                    array_push($values, $db->quote($data['last_name1']));
                            break;
                        case 'last_name2':                            
                    array_push($values, $db->quote($data['last_name2']));
                            break;
                            case 'business_name':                          
                    array_push($values, $db->quote($data['business_name']));

                                break;
                        case 'cellphone':
                  array_push($values,$db->quote($data['cellphone']));
                        break;       
                        case 'create_at':

                  array_push($values,$db->quote(date("Y-m-d h:i:s A")));

                            break;
                        default:
                    array_push($values,$db->quote(''));
                        break;
                        }    
            }

            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('id'))
                    ->from($db->quoteName('#__core_user_info'))
                    ->where($db->quoteName('user_id') . ' = ' . $db->quote($userId))
                    ->setLimit('1');

            $db->setQuery($query);
            $user_info_id = $db->loadResult();
            
            if ($user_info_id !=null) {
                $query = $db->getQuery(true);

                $fields = array(
                $db->quoteName('state_id') . ' = ' .$data['state'],
                $db->quoteName('branch_office') . ' = ' . $db->quote($data['office']),
                $db->quoteName('cellphone') . ' = ' . $db->quote($data['cellphone']),                            
                
                $db->quoteName('last_name1') . ' = ' . $db->quote($data['last_name1']),
                $db->quoteName('last_name2') . ' = ' . $db->quote($data['last_name2']),                
                $db->quoteName('business_name') . ' = ' . $db->quote($data['business_name']));                            
                             
                $conditions = array(
                    $db->quoteName('user_id') . ' = ' . $db->quote($userId)
                );
                $query->update($db->quoteName('#__core_user_info'))->set($fields)->where($conditions);
                $db->setQuery($query);
               $result= $db->execute();
            }else{

            $query = $db->getQuery(true);
            $query
                ->insert($db->quoteName('#__core_user_info'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            $db->setQuery($query);
            $result=  $db->execute();

            }

             $this->changeStatusUser($userId);   
             $this->saveCinema($data,$userId);

        } catch (Exception $e) {

            $this->logError('Error' . $e->getMessage() . " Datos no registrados " . json_encode($data) . chr(10) . chr(13));
            $this->_subject->setError($e->getMessage());
            return false;
        }

        return true;
    }

private function changeStatusUser($userId){
                    $db = JFactory::getDbo();        
          $query = $db->getQuery(true);
                
            $fields = array(
                $db->quoteName('block') . ' = 0');
            $conditions = array(
                $db->quoteName('id') . ' = ' . $db->quote($userId)
            );
            $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
            $db->setQuery($query);
            $db->execute();
}

private function saveCinema($data,$userId)
{

        $db = JFactory::getDbo();

            $columns = array(
                'id',
                'quantity',
                'ticket_type',
                'user_id',
                'email',
                'name',                    
                'body_request',
                'create_at',
                'is_purchased'
            );            
            $values = array(
            
                $db->quote(null),
                $db->quote(1),
                $db->quote(1),
                $db->quote($userId),
                $db->quote($data['email']),
                $db->quote($data['name']),
                $db->quote(''),                
                $db->quote(date("Y/m/d h:i:s A")),
                $db->quote(0)
            );    
            $query = $db->getQuery(true);
            $query
                    ->insert($db->quoteName('#__core_adcinema'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();

}

    private function registerCase($data, $userId, $jinput) {


        return true;
    }

    private function updateCase($data, $userId, $jinput) {
        var_dump("update case");
        die();
        try {
            //Procesar archivos (INE)
            $validFiles = array('jpg', 'jpeg', 'png', 'pdf');

            $post_files = $jinput->files->get('jform');

            $ip = JFactory::getApplication()->input->server->get('REMOTE_ADDR', '-');
            $withIne = false;
            if (array_key_exists('ine', $post_files)) {
                if (strlen($post_files['ine']['name']) > 3) {
                    jimport('joomla.filesystem.file');

                    $fine_filename = JFile::makeSafe($post_files['ine']['name']);
                    $ext = JFile::getExt($fine_filename);
                    $name = JFile::stripExt($fine_filename);

                    $new_file_name = substr(md5($name), 0, 10) . time() . '.' . $ext;

                    $src = $post_files['ine']['tmp_name'];
//                      $dest = __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $new_file_name;
                    $dest = JPATH_BASE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $new_file_name;
                    try {
                        if (in_array(strtolower($ext), $validFiles)) {
                            JFile::upload($src, $dest);
                            $withIne = true;
                        } else {
                            throw new Exception('Archivo inválido');
                        }
                    } catch (Exception $e) {
                        $this->logError("not upload " . $e->getMessage() . chr(10) . chr(13));
                        $this->_subject->setError($e->getMessage());
                        return false;
                    }
                }
            }

            $db = JFactory::getDbo();

            // Fields to update.
            $fields = array(
                $db->quoteName('name') . '=' . $db->quote($data['name']),
                $db->quoteName('midname') . '=' . $db->quote($data['midname']),
                $db->quoteName('lastname') . '=' . $db->quote($data['lastname']),
                $db->quoteName('curp') . '=' . $db->quote($data['curp']),
                $db->quoteName('gmin') . '=' . $db->quote($data['gmin']),
                $db->quoteName('pid') . '=' . $db->quote($data['pid']),
                $db->quoteName('telephone') . '=' . $db->quote($data['telephone']),
                $db->quoteName('cellphone') . '=' . $db->quote($data['cellphone']),
                $db->quoteName('ip') . '=' . $db->quote($ip)
            );


            if ($withIne) {
                array_push($fields, $db->quoteName('ine') . '=' . $db->quote($new_file_name));
                array_push($fields, $db->quoteName('ine_upload_date') . '=' . $db->quote(date('Y-m-d H:i:s')));
                array_push($fields, $db->quoteName('ine_status') . '=' . $db->quote('Por_validar'));
            }

            $query = $db->getQuery(true);
            // Conditions for which records should be updated.
            $conditions = array(
                $db->quoteName('user_id') . ' = ' . $db->quote($userId),
            );
            $this->logError($query->__toString() . chr(10) . chr(13));
            $query->update($db->quoteName('#__core_user_info'))
                    ->set($fields)
                    ->where($conditions);
            $this->logError($query->__toString() . chr(10) . chr(13));
            $db->setQuery($query);
            $db->execute();
            $query = $db->getQuery(true);
            $fields = array(
                $db->quoteName('name') . ' = ' . $db->quote(
                        $data['name'] . ' ' . $data['midname'] . ' ' . $data['lastname']
                )
            );
            $conditions = array(
                $db->quoteName('id') . ' = ' . $db->quote($userId)
            );

            $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
            $db->setQuery($query);
            $db->execute();
        } catch (Exception $e) {
            $this->logError('Error' . $e->getMessage() . " Datos no actualizados " . json_encode($data) . chr(10) . chr(13));
            $this->_subject->setError($e->getMessage());
            return false;
        }

        return true;
    }

    private function logError($param) {
        $handle = fopen('/var/www/html/logs/register-error.log', 'a+');
        fwrite($handle, date('d-M-Y G:i:s') . ' => ' . $param . chr(10) . chr(13));
        fclose($handle);
    }

    public function onUserAfterDelete($user, $success, $msg) {
        if (!$success) {
            return false;
        }

        $db = JFactory::getDbo();

        $userId = ArrayHelper::getValue($user, 'id', 0, 'int');

        //Obtener nombre de archivo a eliminar
        $query = $db->getQuery(true);
        $query
                ->select($db->quoteName('ine'))
                ->from($db->quoteName('#__core_user_info'))
                ->where($db->quoteName('user_id') . ' = ' . $db->quote($userId))
                ->setLimit('1');

        $db->setQuery($query);

        $file_user_delete = $db->loadResult();

        if (strlen($file_user_delete) > 3) {

            try {
                unlink(__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $file_user_delete);
            } catch (Exception $e) {
                $this->_subject->setError($e->getMessage());
                return false;
            }
        }

        //Elminar registro de la BD

        if ($userId) {

            try {

                $query = $db->getQuery(true);

                $conditions = array(
                    $db->quoteName('user_id') . ' = ' . $db->quote($userId)
                );

                $query->delete($db->quoteName('#__core_user_info'))
                        ->where($conditions);

                $db->setQuery($query);

                $result = $db->execute();

                //Dealer
                $query = $db->getQuery(true);

                $conditions = array(
                    $db->quoteName('userid') . ' = ' . $db->quote($userId)
                );

                $query->delete($db->quoteName('#__core_users_cedis_map'))
                        ->where($conditions);

                $db->setQuery($query);

                $result = $db->execute();
            } catch (Exception $e) {
                $this->_subject->setError($e->getMessage());

                return false;
            }
        }

        return true;
    }

}
