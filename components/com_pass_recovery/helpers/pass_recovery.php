<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;
$app = JFactory::getApplication();
JLoader::register('Pass_recoveryHelper', JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_pass_recovery' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'pass_recovery.php');

/**
 * Class Pass_recoveryFrontendHelper
 *
 * @since  1.6
 */
class Pass_recoveryHelpersPass_recovery
{
	
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_pass_recovery/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_pass_recovery/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Pass_recoveryModel');
		}

		return $model;
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function canUserEdit($item)
    {
        $permission = false;
        $user       = JFactory::getUser();

        if ($user->authorise('core.edit', 'com_pass_recovery'))
        {
            $permission = true;
        }
        else
        {
            if (isset($item->created_by))
            {
                if ($user->authorise('core.edit.own', 'com_pass_recovery') && $item->created_by == $user->id)
                {
                    $permission = true;
                }
            }
            else
            {
                $permission = true;
            }
        }

        return $permission;
	}
	
	public static function getValidPhone($phone){
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__user_profiles');
		$query->where($db->quoteName('profile_value') . ' = '. $db->quote('"'.$phone.'"'));
		$db->setQuery((string) $query);
		$result = $db->loadObjectList();
		if(isset($result[0]) && $result[0]!=null){
			return $result[0];
		}else{
			return null;
		}
	}

	public static function setPhoneCode($phone, $user_id){
		$verify_valid_code = Pass_recoveryHelpersPass_recovery::getExistingCode($user_id);
		//Verificacion de código vigente existente
		$code = Pass_recoveryHelpersPass_recovery::getRandomStr($user_id);
		$app = JFactory::getApplication();
		$params = $app->getParams();
		if($params->get('time_limit') != null){
			$time_limit = $params->get('time_limit');
		}else{
			$time_limit = 15;
		}
		
		if($verify_valid_code==true){
			$code = Pass_recoveryHelpersPass_recovery::getRandomStr();
			date_default_timezone_set("America/Monterrey");
			$date = date("Y-m-d G:i:s", strtotime("+".$time_limit." Minutes"));
			$db = JFactory::getDbo();
			// Create a new query object.
			$query = $db->getQuery(true);
			// Insert columns.
			$columns = array('code', 'user', 'phone', 'time_limit');
			// Insert values.
			$values = array($db->quote($code), $db->quote($user_id), $db->quote($phone), $db->quote($date));
			// Prepare the insert query.
			$query
				->insert($db->quoteName('#__core_pass_recovery'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values));
			
			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();
			Pass_recoveryHelpersPass_recovery::sendSms($code, $phone, $date, $user_id);
		}else if ($verify_valid_code == null){
			return '500';
		}
		
	}

	public static function getRandomStr(){
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$string = '';
		$max = strlen($characters) - 1;
		for ($i = 0; $i < 10; $i++) {
			 $string .= $characters[mt_rand(0, $max)];
		}
		return $string;
	}

	public static function getExistingCode($user_id){
		
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('time_limit');
		$query->from('#__core_pass_recovery');
		$query->where($db->quoteName('user') . ' = '. $db->quote($user_id));
		$db->setQuery((string) $query);
		$result = $db->loadObjectList();
		if(isset($result[0]) && $result[0]!=null){
			date_default_timezone_set("America/Monterrey");
			$date1 = $result[count($result)-1]->time_limit;
			$date2 = date("Y-m-d G:i:s");
			if($date2 > $date1){
				return true;
			}else {				
				return null;
			}
		}else{
			return true;
		}
	}

	//Function created for verifycode view
	public static function getCode($code){
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__core_pass_recovery');
		$query->where($db->quoteName('code') . ' = '. $db->quote($code));
		$db->setQuery((string) $query);
		$result = $db->loadObjectList();
		if($result!=null){
			return $result[0];			
		}else{
			return null;
		}
	}


	public static function codeAccepted($code){
		//Verificacion de código vigente existente
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
			$db->quoteName('state') . ' = ' . $db->quote('0')
		);
		
		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('code') . ' = '.$db->quote($code)
		);
		
		$query->update($db->quoteName('#__core_pass_recovery'))->set($fields)->where($conditions);
		
		$db->setQuery($query);
		
		$result = $db->execute();
		
	}

	public static function changePassword($pass, $user){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Fields to update.
		$fields = array(
			$db->quoteName('password') . ' = ' . $db->quote(md5($pass))
		);
		
		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('id') . ' = '.$db->quote($user)
		);
		
		$query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
		
		$db->setQuery($query);
		
		$result = $db->execute();
	}

	public static function sendSms($code, $phone, $date, $user){
	    $wsdl_url = 'http://calixtaondemand.com/ws/webService.php?wsdl';
	    $cliente = new SoapClient($wsdl_url, array('cache_wsdl' => 0,));
	    $idCliente = '45357';
	    $email = 'liliana.villalvazo@adventa.mx';
	    $password = '988fd0559ff29fc780a64c1ea2b1fd20693f1583d8ebe0090702f1795810b1fa';
	    $tipo = 'SMS';
	    $mensaje = 'Tu código es: '.$code.' y expira el dia: '.$date.'.';
	    //$cliente->setSoapVersion(SOAP_1_1);
	    $telefono = $phone;
	    $response = $cliente->EnviaMensajeOL($idCliente, $email, $password, $tipo, $telefono, $mensaje, '125');
		}
}
