<?php
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

//use Zend\Soap\Client;


class plgSystemUserCustom extends JPlugin
{
	public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);
    }	
	
	public function onAfterRoute()
	{
		$app = JFactory::getApplication();
		if($app->input->get('plg', '') != 'usercustom'){
			return true;
		}
	
		$task = $app->input->get('task', '');
		
		$token = $app->input->post->get('token', '');

		if( md5($token) == md5(JSession::getFormToken()) )
		{
			switch ($task){
				case 'get_sucursal' :
						$id_estado = $app->input->post->getHTML('estado_id', '');
						$response = $this->getSucursalesByEstadoId($id_estado);
                    echo $response;

				break;
                case 'valida_numero_tarjeta':
                    $number = $app->input->post->getHTML('numero_tarjeta', '');
                    $response=$this->validateNumber($number);
                    echo json_encode($response);

                    break;                 
                    case 'valida_email':
                    $email = $app->input->post->getHTML('email', '');
                    $response=$this->validateUser($email);
                    echo json_encode($response);			
					
                    break;

			}
		}
	else
		{
			JError::raiseError(404, JText::_("Page Not Found"));
		}
		
	
		exit();		
	}

    public function  getSucursalesByEstadoId($id){
        $client = new SoapClient("http://www.apymsa.com.mx/ExodusWeb/Servicios/Adventa.asmx?op=ClientePenalizado&wsdl",
            array('compression' => SOAP_COMPRESSION_ACCEPT, 'encoding' => 'UTF-8'));
        $param = array(
            'Usuario' => 'Adventa2015',
            'PassWord' => 'HDk86djF5$6jh',
            'EstadoID' => $id
        );
        $result = $client->RecuperaSucursales($param)->RecuperaSucursalesResult;
        return $result;
    }


    public function validateNumber($numero)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $no_registrado="No Registrado";
        // Get the database object and a new query object.
        $query->select('u.*')
            ->from($db->quoteName('#__users','u'))
            ->where('u.username  = ' . $db->quote($numero));
        // Set and query the database.

        $db->setQuery($query);
        $response= $db->loadObject();
        
        if($response!=null){
            if($response->name=="No Registrado"&&$response->email==null||$response->name==null){
                return array(
                    "data"=>true,
                    "code"=>200,
                    "id_user"=>$response->id
                );

            }else{

                return array(
                    "data"=>false,
                    "id_user"=>null,
                    "code"=>300
                );

            }

        }else{
            return array(
                "data"=>null,
                "id_user"=>null,
                "code"=>500
            );
        }

    }



	public function getUsers($dealer)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// Get the database object and a new query object.
		$query->select('u.name, u.id, ug.title AS profile')
			->from($db->quoteName('#__users','u'))
			->join('INNER', $db->quoteName('#__core_users_cedis_map', 'm').' ON ('.$db->quoteName('m.userid').' = '.$db->quoteName('u.id').')')
			->join('INNER', $db->quoteName('#__user_usergroup_map', 'um').' ON ('.$db->quoteName('um.user_id').' = '.$db->quoteName('u.id').')')
			->join('INNER',$db->quoteName('#__usergroups', 'ug').' ON ('.$db->quoteName('ug.id').' = '.$db->quoteName('um.group_id').')')
			->where('m.cedisid = ' . $db->quote($dealer));
			
		// Set and query the database.
		$db->setQuery($query);
		
		$response= $db->loadObjectList();
		
		if($response){
			return $response;
		}else{
			return false;
		}
		
	}



    public function validateUser($email)
    {

    	try {
    		$valido=true;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $no_registrado="No Registrado";
        // Get the database object and a new query object.
        $query->select('u.*')
            ->from($db->quoteName('#__users','u'))
            ->where('u.email  = ' . $db->quote($email));
        // Set and query the database.

        $db->setQuery($query);
        $response= $db->loadObjectList();

     if (count($response)>0) {
     	$valido=false;
     }else{
     	$valido=true;
     }    		
    	} catch (Exception $e) {
    	return false;		
    	}
   return $valido; 	
}

}
