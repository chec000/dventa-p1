<?php

defined('_JEXEC') or die;

class PerfilControllerFunciones extends JControllerLegacy
{
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

    public function activateUser()
    {
        $app = JFactory::getApplication();

        $model = $this->getModel('perfiles');
        $userId = $app->input->post->get('id', '');
        $status = $app->input->post->get('status', '');

         return   $model->updateStatus($userId,$status);
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
        $id_usuario = $app->input->get->get('id_usuario', '');
        $post_array = $app->input->getArray($_GET);
       
       try {
         $db = JFactory::getDbo();
         $query = $db->getQuery(true);               
            $query->select('id')
            ->from($db->quoteName('#__users'))
            ->where('email='.$db->quote($post_array['vars']['email'])
            )->andwhere('id !='.intval($post_array['vars']['id_usuario']));
            
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

}