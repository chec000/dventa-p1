<?php
defined('_JEXEC') or die;

class CartModelTransactions extends JModelLegacy
{
  protected static $transactionsTable = '#__core_user_transactions';
  protected static $cartTable = '#__core_user_cart_items';
  protected static $productTable = 'core_products';


  public static function getTransactions(){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $query
      ->select(array('t.id, t.user_id, t.amount, t.type, t.correlation_id, 
        t.balance_snapshot, t.details, t.created_at, t.applied_at'))
      ->from($db->quoteName(self::$transactionsTable, 't'))
      ->where('t.user_id = ' . $db->Quote($user));
      $db->setQuery($query);
      $results = $db->loadObject();
    }
    return $results;
  }

  public static function getBalance(){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $query
      ->select(array('sum(t.amount) as value'))
      ->from($db->quoteName(self::$transactionsTable, 't'))
      ->where('t.user_id = ' . $db->Quote($user));
      $db->setQuery($query);
      $results = $db->loadObject();
    }
    return $results;
  }
}