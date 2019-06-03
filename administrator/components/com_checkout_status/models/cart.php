<?php
defined('_JEXEC') or die;

class Checkout_StatusModelCart extends JModelLegacy
{
  protected $cartTable = '#__core_user_cart_items';

  public function emptyCart(){
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query->delete($db->quoteName($this->cartTable));

      $db->setQuery($query);

      $result = $db->execute();
    }
  }
}