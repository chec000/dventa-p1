<?php
defined('_JEXEC') or die;

class DealersControllerUsers extends JControllerAdmin
{

  public function getModel($name = 'User', $prefix ='DealersModel', $config = array('ignore_request' => true))
  {
    $model = parent::getModel($name, $prefix, $config);
    return $model;
  }

}
