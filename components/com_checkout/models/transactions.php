<?php
defined('_JEXEC') or die;

class CheckoutModelTransactions extends JModelLegacy
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

    public static function insertTransactions($data){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser()->id;
        $cart = empty(self::getCartItems()['items'])?0:self::getCartItems()['items'];
        $balance = is_null(self::getBalance()->value)?0:self::getBalance()->value;
        if ($user > 0 && $cart > 0) {
            $transaction = new stdClass();
            $transaction->user_id = $user;
            $transaction->amount = $data * -1;
            $transaction->type = 'order';
            $transaction->correlation_id = 0;
            $transaction->balance_snapshot = $balance;
            $db->insertObject(self::$transactionsTable, $transaction);
        }
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

    private static function getCartItems(){
        $results = array();
        $user = JFactory::getUser()->id;

        if ($user > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
            ->select(array('b.id', 'b.title', 'b.sku, a.quantity, 
                b.file_name, b.price, a.quantity*b.price as lineTotal, b.description, b.brand, b.real_price, b.payload'))
            ->from($db->quoteName(self::$cartTable, 'a'))
            ->join('INNER', $db->quoteName(self::$productTable, 'b') . ' ON (' . 
                $db->quoteName('a.product_id') . ' = ' . 
                $db->quoteName('b.id') . ')')
            ->where('a.user_id = ' . $db->Quote($user))
            ->order($db->quoteName('b.title') . ' ASC');

            $db->setQuery($query);

            $results = $db->loadObjectList();

            $total = 0;
            foreach ($results as $item){
                $total += $item->lineTotal;
            }

            $results['items'] = $results;
            $results['lineTotals'] = $total;
        }

        return $results;
    }
}