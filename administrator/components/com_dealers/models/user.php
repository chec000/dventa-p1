<?php
defined('_JEXEC') or die;

class DealersModelUser extends JModelAdmin
{

  //Prefijo que se usa en los mensajes del controlador
  protected $text_prefix = 'com_dealers';

  /*
  El modelo llama a nuestra tabla la cual es usada para leer y escribir en la BD
  $Prefix = ComponentName+Table
  $type= Debe coincidir con el nombre de la vista
  */
  public function getTable($type = 'User', $prefix = 'UserTable', $config = array())
  {
    return JTable::getInstance($type, $prefix, $config);
  }

//Obtener el form definido en el XML /forms
  public function getForm($data = array(), $loadData = true)
  {

    $app = JFactory::getApplication();

    $form = $this->loadForm('com_dealers.user', 'user', array('control' => 'jform', 'load_data' => $loadData));

    if (empty($form))
    {
      return false;
    }
    return $form;
  }

//Es llamda por getForm y carga los datos desde el form
  protected function loadFormData()
  {

    $data = JFactory::getApplication()->getUserState('com_dealers.edit.user.data', array());
    if (empty($data))
    {
      $data = $this->getItem();
    }
    return $data;
  }

  //Prepara los datos antes de ser desplegados.
  protected function prepareTable($table)
  {
    //$table->title = htmlspecialchars_decode($table->title,ENT_QUOTES);
  }


}
