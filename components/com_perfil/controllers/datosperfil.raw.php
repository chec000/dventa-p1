    <?php

    defined('_JEXEC') or die;

    class PerfilControllerDatosperfil extends JControllerLegacy {


 public function  getSucursales(){
            $app = JFactory::getApplication();
        $id_estado = $app->input->post->getHTML('estado_id', '');
        $client = new SoapClient("http://www.apymsa.com.mx/ExodusWeb/Servicios/Adventa.asmx?op=ClientePenalizado&wsdl",
            array('compression' => SOAP_COMPRESSION_ACCEPT, 'encoding' => 'UTF-8'));
        $param = array(
            'Usuario' => 'Adventa2015',
            'PassWord' => 'HDk86djF5$6jh',
            'EstadoID' => $id_estado
        );
        $result = $client->RecuperaSucursales($param)->RecuperaSucursalesResult;
        echo $result;
    }

    public function getCar()
    {
            $app = JFactory::getApplication();

            $car=null;
                try {
                $id = $app->input->post->get('id', '');
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                // Get the database object and a new query object.
                $query->select('c.*')
                    ->from($db->quoteName('#__cars','c'));
                //->where('z.zip_code like ' . $db->quote($zip));
                $query->where($db->quoteName('c.id')." = ".$db->quote($id));
                // Set and query the database.
                $db->setQuery($query);
                $car=$db->loadObject();
                                      
                   } catch (Exception $e) {
                       echo null;
                   }   

        echo json_encode($car);
       
    }
        public function getDatos()
        {

            $app = JFactory::getApplication();
            $token = $app->input->post->get('token', '');
            $zip = $app->input->post->get('zip', '');

            if (md5($token) == md5(JSession::getFormToken())){
                try{
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $zip='%'.$zip.'%';
                    // Get the database object and a new query object.
                    $query->select('z.*')
                        ->from($db->quoteName('#__zip_codes','z'));
                    $query->where($db->quoteName('z.zip_code')." like ".$db->quote($zip). 'limit 10' );
                    // Set and query the database.
                    $db->setQuery($query);
                    $response= $db->loadObjectList();

                    echo json_encode($response);
                    if($response){
                        return  json_encode($response);
                    }else{
                        return null;
                    }
                }catch (Exception $e){
                   return null;
                }

                }else{
                JError::raiseError(404, JText::_("Page Not Found"));
            }



        }


        public  function getZip()
        {
            $app = JFactory::getApplication();
            $task = $app->input->get('task', '');
            $token = $app->input->post->get('token', '');

            if(md5($token)==md5(JSession::getFormToken())){
                $zip = $app->input->post->get('zip', '');
                try{
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    // Get the database object and a new query object.
                    $query->select('z.*')
                        ->from($db->quoteName('#__zip_codes','z'));
                    //->where('z.zip_code like ' . $db->quote($zip));
                    $query->where($db->quoteName('z.zip_code')." = ".$db->quote($zip));
                    // Set and query the database.
                    $db->setQuery($query);
                    $datos=$db->loadObjectList();
                    if(count($datos)>1) {
                        $response = array(
                            "data" => $datos,
                            "code" => 200,
                            'type'=>1
                        );
                    }else{
                        $response = array(
                            "data" => $db->loadObject(),
                            "code" => 200,
                            'type'=>2
                        );
                        ;
                    }
                    echo  json_encode($response);

                }catch (Exception $e){
                return null;
                }

            }else{
                JError::raiseError(404, JText::_("Page Not Found"));
            }


        }


 public function validaCorreo()
    {
        # code...validaCorreo
        #   data:{email:email,id_usuario:idUsuario,token:key},
        $valid=false;
        $app = JFactory::getApplication();
        $task = $app->input->get('task', '');
        $token = $app->input->get->get('token', '');
        $email = $app->input->get->get('email', '');
        $user = JFactory::getUser();
        $id_usuario = $user->id;
        $post_array = $app->input->getArray($_GET);
       
       try {
         $db = JFactory::getDbo();
         $query = $db->getQuery(true);               
            $query->select('id')
            ->from($db->quoteName('#__users'))
            ->where('email='.$db->quote($post_array['vars']['email'])
            )->andwhere('id !='.$id_usuario);
            
          //
        $db->setQuery($query);
        $response=$db->loadObjectList();
        
        if (count($response)>0) {
            $valid=false;
        }else{
            $valid=true;
        }
       } catch (Exception $e) {
        var_dump($e->getMessage());
           $valid=false;
       }

        echo  json_encode($valid);
    }



    public function savePerfil()
    {

        $jinput = JFactory::getApplication()->input;
        $app = JFactory::getApplication();
        $token = $app->input->post->get('token', '');
    
    if ($token==JSession::getFormToken()) {
    
        $model = $this->getModel('perfil');
        $input = $app->input;
        $data = $input->get('data', array(), 'array');
        $data_array = array();
        $form = $model->getForm($data, false);
        
            foreach ($data as $key => $value) {
              $field=str_replace ( "jform", '',$value['name']);  
            $field=str_replace ( "[", '',$field);
            $field=str_replace( "]", '',$field);
                
            $item= array(
                "name"=>$field,
                "value"=>$value['value']
                );   
            array_push($data_array, $item);
            }

        $data=$data_array;

        if (!$form) {
            $app->enqueueMessage($model->getError(), 'error');
            $errors = $model->getErrors();
            // Display up to three validation messages to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            return false;
        }

        $user = JFactory::getUser();
        //if (!$model->updateData($validData, $userId, $jinput))
        if (!$model->updateData($data, $user->id, $jinput)) {
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

        }

          if (count($data>0)) {
           $fields=$this->getFieldsUser($data);
                  if (count($field)>0) {
                $model->updateUser($fields, $user->id);                    
                  }
          }    
        $app->enqueueMessage(JText::_('COM_PERFIL_TEXT_SAVE'), 'message');
        
 echo json_encode(array('code'=>200,
                'msg'=>JText::_('COM_PERFIL_TEXT_SAVE_EXIT')
    ));
    }else{

        echo json_encode(array('code'=>500,
                'msg'=>JText::_('COM_PERFIL_TEXT_SAVE_FAIL')
    ));
    }

    }
    private function getFieldsUser($list)

    {
      $params = array();
     foreach ($list as $key => $value) {
        $p=$value['name'];
        $v=$value['value'];        
                    
        
            if ($p=='password') {
                $params['password'] = JUserHelper::hashPassword($v);
            }
            if ($p=='email') {
                $params['email'] = $v;
            }
            if ($p=='name') {
                $params['name'] = $v;
            }
     }

    return $params;    
    }


    }
