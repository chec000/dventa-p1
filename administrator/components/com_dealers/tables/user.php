<?php
defined('_JEXEC') or die;

class UserTableUser extends JTable
{

  public function __construct(&$db)
  {
    parent::__construct('#__core_users_cedis_map', 'id', $db);
  }

  //Es usada para preparar los datos inmediatamente antes de ser guardados en la BD
  public function bind($array, $ignore = '')
  {
    return parent::bind($array, $ignore);
  }

  //Almacena los datos en el submit del formulario
  public function store($updateNulls = false)
  {
      return parent::store($updateNulls);

  }

  public function publish($pks = null, $state = 1, $userId = 0)
  {
    $k = $this->_tbl_key;
    JArrayHelper::toInteger($pks);
    $state = (int) $state;

    if (empty($pks))
    {
      if ($this->$k)
      {
        $pks = array($this->$k);
      }
      else
      {
        $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
        return false;
      }
    }

    $where = $k . '=' . implode(' OR ' . $k . '=', $pks);
    $query = $this->_db->getQuery(true)->update($this->_db->quoteName($this->_tbl))->set($this->_db->quoteName('state') . ' = ' . (int) $state)->where($where);
    $this->_db->setQuery($query);

    try
    {
      $this->_db->execute();
    }
    catch (RuntimeException $e)
    {
      $this->setError($e->getMessage());
      return false;
    }

    if (in_array($this->$k, $pks))
    {
      $this->state = $state;
    }

    $this->setError('');
    return true;

  }

  public function check()
  {

      // Check for duplicate entry
      if( (int) $this->id == 0)
      {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from('#__core_users_cedis_map');
        $query->where($db->quoteName('userid') . ' = ' . $db->quote($this->userid));

        $db->setQuery($query);
        $result = $db->loadResult();

        if ($result)
        {
            $this->setError(JText::_(COM_DEALERS_DUPLICATE_USER_ASSOC)." {userid: " . $this->userid . "}");
            return false;
        }else{
          return true;
        }
    }else{
      return true;
    }
  }

}
