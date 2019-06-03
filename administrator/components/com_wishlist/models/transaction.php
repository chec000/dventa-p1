<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistModelTransaction extends JModelLegacy
{
    protected $transactionTable = '#__core_user_transactions';

    public function insertTransactions($params){
        $db = $this->getDbo();
        $balance = is_null($this->getBalance($params['user_id'])->value)?
        0:$this->getBalance($params['user_id'])->value;

        $transaction = new stdClass();
        $transaction->user_id = $params['user_id'];
        $transaction->amount = $params['amount'];
        $transaction->type = $params['type'];
        $transaction->correlation_id = $params['correlation_id'];
        $transaction->balance_snapshot = $balance;
        $db->insertObject($this->transactionTable, $transaction);
        return $db->insertid();
    }

    public function getBalance($user_id){
        $results = array();
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('sum(t.amount) as value'))
        ->from($db->quoteName($this->transactionTable, 't'))
        ->where('t.user_id = ' . $db->Quote($user_id));
        $db->setQuery($query);
        $results = $db->loadObject();
        return $results;
    }

}