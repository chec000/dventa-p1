<?php
defined('_JEXEC') or die;

class WishlistModelTransaction extends JModelLegacy
{
  protected $transactionsTable = '#__core_user_transactions';

  public function insertTransactions($params){
    $db = JFactory::getDbo();
    $balance = is_null($this->getBalance()->value)?
    0:$this->getBalance()->value;

    $transaction = new stdClass();
    $transaction->user_id = $params['user_id'];
    $transaction->amount = $params['amount'];
    $transaction->type = $params['type'];
    $transaction->correlation_id = $params['correlation_id'];
    $transaction->balance_snapshot = $balance;
    $db->insertObject($this->transactionsTable, $transaction);
    return $db->insertid();
  }

  public function getBalance(){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $query
      ->select(array('sum(t.amount) as value'))
      ->from($db->quoteName($this->transactionsTable, 't'))
      ->where('t.user_id = ' . $db->Quote($user));
      $db->setQuery($query);
      $results = $db->loadObject();
    }
    return $results;
  }
}