<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Report
 * @author     Othon Parra Alcantar <othon.parra@adventa.mx>
 * @copyright  
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Userfields list controller class.
 *
 * @since  1.6
 */
class ReportControllerUserfields extends JControllerAdmin
{
	/**
	 * Method to clone existing Userfields
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_REPORT_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_REPORT_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_report&view=userfields');
	}

	//Download report button function
	public function download(){
		$app = JFactory::getApplication();
		$field_merge = array();
		$user_data=array();
		$user_cedis="";
		$cedis_data=(object) array();
		$user_profiles=(object) array();
		
		// Get the model
		$model = $this->getModel($name = 'userfields', $prefix = 'ReportModel', $config = array());
		$roles = $model->getUsersRole();
		//Obtiene datos del modelo
		$fields= $model->getActiveFIelds();
		$users = $model->getUsers();
		//Core_configs---core.cedis->value
		$core_cedis = $model->getCedisValue();
		if ($core_cedis == 'cedis')
		{
			$core_cedis='1';
		}else{
			$core_cedis='0';
		}
		//Tomar la fecha y hora actual
		date_default_timezone_set('America/Monterrey');
		$date = date('Y-m-d H-i-s');
		
		
		//Nombre del archivo de reporte
		$filename = "Usuarios_report ".$date;
		
		$output = fopen('php://output', 'w');
		
		//Toma todos los nombes de los campos y los ingresa a un solo arreglo
		foreach ($fields as $field){
			array_push($field_merge,$field->field_name);
		}
		//Imprime las cabeceras de las columnas
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $field_merge);

		foreach ($users as $user)
		{ 
			$user_cedis = $model->getUserCedis($user->id);
			$cedis_data = $model->getCedisInfo($user_cedis);				
			foreach ($fields as $field){
				if ($field->field == "user"){
					array_push($user_data, $user->username);
				}
				else if($field->field == "name"){
					array_push($user_data, $user->name);
				}
				else if($field->field == "email"){
					array_push($user_data, $user->email);
				}
				else if($field->field == "visits"){
					$user_visits = $model->getUserVisits($user->id);
					array_push($user_data, $user_visits);
				}
				else if($field->field == "registry_date"){
					array_push($user_data, $user->registerDate);
				}
				else if($field->field == "last_visit"){
					array_push($user_data, $user->lastvisitDate);
				}
				else if($field->field == "status"){
					if($user->block == 0){array_push($user_data, "Activo");}
					else if($user->block == 1){array_push($user_data, "Bloqueado");}
				}
				else if($field->field == "profile"){
					$profile = $model->getUserProfile($user->id);
					array_push($user_data, $roles[$user->id]['title']);
				}
				else if($field->field == "canjeados"){
					$canjeados =  $model->getOrders($user->id);
					array_push($user_data, $canjeados);
				}
				else if($field->field == "disponibles"){
					$disponibles =  $model->getPoints($user->id);
					array_push($user_data, $disponibles);
				}
				else if($field->field == "acumulados"){
					$acumulados=  $model->getPointsAcum($user->id);
					array_push($user_data, $acumulados);
				} 
				/*else{
					array_push($user_data, "----");
				}*/

				//Si core_cedis existe para el usuario
				/*if($core_cedis == '1'){
					if ($field->field == "id_cedis"){
						if(isset($cedis_data->cedis_id)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->cedis_id);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "cedis_name"){
						if(isset($cedis_data->names_cedis)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->names_cedis);
							}
						}
						else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "street"){
						if(isset($cedis_data->street)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->street);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "num_ext"){
						if(isset($cedis_data->ext_number)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->ext_number);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "num_int"){
						if(isset($cedis_data->int_number)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->int_number);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "neighborhood"){
						if(isset($cedis_data->location)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->location);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "reference"){
						if(isset($cedis_data->reference)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->reference);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "city"){
						if(isset($cedis_data->city)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->city);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "estate"){
						if(isset($cedis_data->estate)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->estate);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "cp"){
						if(isset($cedis_data->zip_code)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->zip_code);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}

				}
				else if($core_cedis == '0'){
					//When core cedis is disabled	
					if ($field->field == "id_cedis"){
						if(isset($cedis_data->cedis_id)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->cedis_id);
							}
						}else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "cedis_name"){
						if(isset($cedis_data->names_cedis)){
							if($cedis_data != '0'){
								array_push($user_data, $cedis_data->names_cedis);
							}
						}
						else{
							array_push($user_data, "N/D");
						}
						
					}
					else if ($field->field == "street"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.street');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "num_ext"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.num_ext');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "num_int"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.num_int');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "neighborhood"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.neighborhood');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "reference"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.reference');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "city"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.town');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "estate"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.estate');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
					else if ($field->field == "cp"){
						$user_profiles = $model->getProfileByKey($user->id,'profile.pc');
						if(isset($user_profiles->profile_value)){
							array_push($user_data,str_replace('"','',$user_profiles->profile_value));
						}else{
							array_push($user_data, "N/D");
						}	
					}
						
				}
				if ($field->field == "num_tel"){
					$user_profiles = $model->getProfileByKey($user->id,'profile.num_tel');
					if(isset($user_profiles->profile_value)){
						array_push($user_data,str_replace('"','',$user_profiles->profile_value));
					}else{
						array_push($user_data, "N/D");
					}
					
				}
				else if ($field->field == "num_cel"){
					$user_profiles = $model->getProfileByKey($user->id,'profile.num_cel');
					if(isset($user_profiles->profile_value)){
						array_push($user_data,str_replace('"','',$user_profiles->profile_value));
					}else{
						array_push($user_data, "N/D");
					}
					
				}
				else if ($field->field == "last_name1"){
					$user_profiles = $model->getProfileByKey($user->id,'profile.last_name1');
					if(isset($user_profiles->profile_value)){
						array_push($user_data,str_replace('"','',$user_profiles->profile_value));
					}else{
						array_push($user_data, "N/D");
					}
					
				}
				else if ($field->field == "last_name2"){
					$user_profiles = $model->getProfileByKey($user->id,'profile.last_name2');
					if(isset($user_profiles->profile_value)){
						array_push($user_data,str_replace('"','',$user_profiles->profile_value));
					}else{
						array_push($user_data, "N/D");
					}
					
				}*/
				
			}
			fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
			fputcsv($output, $user_data);
			$user_data = array();
			//	print ($user->username)."\n";  
		}
		
		
				// write the header for an object in stead of html file.
		$app
			-> setHeader('Content-Type', 'application/cvs; charset=utf-8', true)
			//-> setHeader('Content-Length', strlen($content), true)
			-> setHeader('Content-Disposition', 'attachment; filename="'.$filename.'.csv"', true)
			-> setHeader('Content-Transfer-Encoding', 'binary', true)
			-> setHeader('Expires', '0', true)
			-> setHeader('Pragma','no-cache',true);
		
		// Close the application gracefully.
		$app->sendHeaders();
		$app->close();

	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Optional. Model name
	 * @param   string  $prefix  Optional. Class prefix
	 * @param   array   $config  Optional. Configuration array for model
	 *
	 * @return  object	The Model
	 *
	 * @since    1.6
	 */
	public function getModel($name = 'userfield', $prefix = 'ReportModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks   = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}

	public function downloadRedirect(){
		$this->setRedirect('index.php?option=com_report&view=download_users');
	}
}
