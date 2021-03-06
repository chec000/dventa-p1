<?php
defined('_JEXEC') or die;

class WishlistModelAdcinema extends JModelLegacy
{
  protected $adcinemaTable = '#__core_adcinema';

  public function insertItem($params){
    $user = JFactory::getUser();
    if ($user->id > 0) {
      $item = new stdClass();
      $item->quantity = $params['quantity'];
      $item->ticket_type = $params['type'];
      $item->user_id = $user->id;
      $item->email = $user->email;
      $item->name = $user->name;
      $item->body_request = '';

      $result = JFactory::getDbo()
      ->insertObject($this->adcinemaTable, $item);
    }
  }
}