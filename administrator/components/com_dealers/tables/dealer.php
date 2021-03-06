<?php
defined('_JEXEC') or die;

class DealerTableDealer extends JTable
{

  public function __construct(&$db)
  {
    parent::__construct('#__core_cedis', 'id', $db);
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

}
