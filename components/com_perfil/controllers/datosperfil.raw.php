    <?php

    defined('_JEXEC') or die;

    class PerfilControllerDatosperfil extends JControllerLegacy {

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



    }
