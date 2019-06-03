<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Layoutpoint
 * @author     EDGAR <edgarmaster89@hotmail.com>
 * @copyright  2017 EDGAR
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Uploadfiles list controller class.
 *
 * @since  1.6
 */
class LayoutpointControllerUploadfiles extends JControllerAdmin
{
	/**
	 * Method to clone existing Uploadfiles
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
				throw new Exception(JText::_('COM_LAYOUTPOINT_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_LAYOUTPOINT_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_layoutpoint&view=uploadfiles');
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
	public function getModel($name = 'uploadfile', $prefix = 'LayoutpointModel', $config = array())
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

	public function download(){
        //$file_id = $_GET['id']; 
        //$data = $this->getData($file_id);
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"Layout_carga_puntos.csv\""); 

        $outputBuffer = fopen("php://output", 'w');
        $header= array('username', 'mes', 'anio', 'ventas', 'cuota', 'puntos');

        fputcsv($outputBuffer, $header);

        fclose($outputBuffer);
        exit;
    }

    public function downloadFile(){
        $file_id = $_GET['id']; 
        //var_dump($file_id); die();
        $model = $this->getModel();
        $data = $model->getData($file_id);
        
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"Layout_carga_ajustes.csv\""); 

        $outputBuffer = fopen("php://output", 'w');
        $header= array('username', 'amount', 'created_at');

        foreach ($data as $row) {
            
            $csv_array[] = $row;
            
        }
        if(isset($csv_array)){
        fputcsv($outputBuffer, $header);

        foreach($csv_array as $val) {
            $val = get_object_vars( $val );
            fputcsv($outputBuffer, $val);
        }
      }
        
        fclose($outputBuffer);
        exit;
    }

    public function upload(){
    $model = $this->getModel();
    $input = JFactory::getApplication()->input;
    $file  = $input->files->get('myfile');
    $description = JRequest::getVar('description');

    //define el nombre del archivo
    $fecha=date('Y-m-d');
    $fecha_time=time();
    $file_fecha_time='Layout_carga_puntos'.$fecha_time.'.csv';
  
    $ruta_destino_archivo = "components/com_layoutpoint/files/{$file_fecha_time}";
    $archivo_ok = move_uploaded_file($file['tmp_name'], $ruta_destino_archivo);
    if($archivo_ok){
      $lastFile = $model->getLastFile();
      $lastFile = $lastFile + 1;
      $model->setFile($file_fecha_time,$description);
      $registros = array();
      if (($fichero = fopen($ruta_destino_archivo, "r")) !== FALSE) {
        // Lee los nombres de los campos
        $nombres_campos = fgetcsv($fichero, 0, ",", "\"", "\"");
        $num_campos = count($nombres_campos);
        // Lee los registros
          while (($datos = fgetcsv($fichero, 0, ",", "\"", "\"")) !== FALSE) {
           // Crea un array asociativo con los nombres y valores de los campos
             for ($icampo = 0; $icampo < $num_campos; $icampo++) {
                $registro[$nombres_campos[$icampo]] = $datos[$icampo];
              }
              // Añade el registro leido al array de registros
              $registros[] = $registro;
          }           
      fclose($fichero);


          for ($i = 0; $i < count($registros); $i++) {
            
            $user_id=$model->getUserId($registros[$i]["username"]);
            $fila=$i+1;
              
            if(isset($user_id)){
              	//$model->setPmrRules($registros[$i],(int)$user_id->id);
              	$model->setTransactions($registros[$i],(int)$user_id->id,$lastFile,$description);
              }
           }
      }unlink($ruta_destino_archivo);
      echo "<script>window.location.href = 'index.php?option=com_layoutpoint'</script>";
    }
  }
}
