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

jimport('joomla.application.component.modeladmin');

/**
 * Layoutpoint model.
 *
 * @since  1.6
 */
class LayoutpointModelUploadfile extends JModelAdmin
{
	public function getForm ($data = array(), $loadData = true)
	{
	
	}

	public function getItems()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
				$query
    				->select('*')
    				->from($db->quoteName('#__core_file_uploads', 'a'))
    				->where($db->quoteName('file_type') . " IN ('results')");
    				$db->setQuery($query);
    				$results = $db->loadObjectList();

    	return $results;
	}

	public function getLastFile(){
        $db = JFactory::getDbo();
        $lastFile = $db->getQuery(true);
        $lastFile
        ->select('MAX(id) as id')
        ->from($db->quoteName('#__core_file_uploads', 'a'));
        $db->setQuery($lastFile);
        $result = $db->loadResult();

        return $result;
  }

  public function getUserId($username){

    $db = JFactory::getDbo();
    $query_period = $db->getQuery(true);
        $query_period
            ->select(array('a.id'))
            ->from($db->quoteName('#__users', 'a'))
            ->where($db->quoteName('username')." = ".$db->quote($username));
            $db->setQuery($query_period);
            $results = $db->loadObject();

      return $results;
  }

  public function setPmrRules($row,$user_id){
    
    //$timestamp = date('Y-m-d G:i:s');
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    // Insert columns.
    $columns = array('user_id', 'mes', 'anio', 'ventas', 'cuota', 'puntos');

    // Insert values.
    $values = array($db->quote($user_id), $db->quote($row['mes']), $db->quote($row['anio']), $db->quote($row['ventas']),$db->quote($row['cuota']),$db->quote($row['puntos']));

    // Prepare the insert query.
    $query
      ->insert($db->quoteName('#__core_pmr_rules'))
      ->columns($db->quoteName($columns))
      ->values(implode(',', $values));
      
    // Set the query using our newly populated query object and execute it.
    $db->setQuery($query);
    $db->execute();
  }

  public function setTransactions($row,$user_id,$lastFile,$description){

    $balance_snapshot=$this->getBalanceSnapshot($user_id) ?: 0;

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    // Insert columns.
    $columns = array('user_id', 'amount', 'type', 'correlation_id', 'details', 'balance_snapshot');

    // Insert values.
    $values = array($db->quote($user_id), $db->quote($row['puntos']), $db->quote('result'), $db->quote($lastFile),$db->quote($description), $db->quote($balance_snapshot));

    // Prepare the insert query.
    $query
      ->insert($db->quoteName('#__core_user_transactions'))
      ->columns($db->quoteName($columns))
      ->values(implode(',', $values));
      
    // Set the query using our newly populated query object and execute it.
    $db->setQuery($query);
    $db->execute();
  }

  private function getBalanceSnapshot($user_id)
    {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query
      ->select('SUM(amount) as available')
      ->from($db->quoteName('#__core_user_transactions', 'a'))
      ->where($db->quoteName('user_id')." = ".$db->quote($user_id));
            
      $db->setQuery($query);
      $result = $db->loadResult();
      

       return $result;
    }

    public function setFile($file_name,$description){
    $user = JFactory::getUser();
    //echo $user->id;
    //var_dump($user->id); die();

    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    // Insert columns.
    $columns = array('user_id','description','file_name','file_type');

    // Insert values.
    $values = array($db->quote($user->id), $db->quote($description), $db->quote($file_name),$db->quote('results'));

    // Prepare the insert query.
    $query
      ->insert($db->quoteName('#__core_file_uploads'))
      ->columns($db->quoteName($columns))
      ->values(implode(',', $values));
      
    // Set the query using our newly populated query object and execute it.
    $db->setQuery($query);
    $db->execute();
  }

  public function getData($file_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('b.username', 'amount', 'created_at'))
        ->from($db->quoteName('#__core_user_transactions', 'a'))
        ->join('LEFT', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.user_id') . ')')
        ->where($db->quoteName('type')." = ".$db->quote('result'))
        ->where($db->quoteName('correlation_id')." = ".$db->quote($file_id));
                    
        $db->setQuery($query);
        $results = $db->loadObjectList();
        

       return $results;
    }
}
