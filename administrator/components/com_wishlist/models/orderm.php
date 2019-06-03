<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistModelOrderm extends JModelLegacy
{
    protected $ordersTable = '#__core_wishlist_orders';
    protected $orderProductsTable = '#__core_wishlist_order_products';

    public function getOrder($id)
    {
        $results = array();
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('o.id, o.user_id, o.total, o.deleted_at'))
        ->from($db->quoteName($this->ordersTable, 'o')) 
        ->where('o.id = ' . $db->Quote($id));
        $db->setQuery($query);
        $results = $db->loadObject();
        return $results;
    }

    public function createOrderProducts($params, $order_id, $quantity){
        $db = $this->getDbo();
        $products = JModelLegacy::getInstance('Product', 'WishlistModel');
        $product = $products->getProduct($params);

        if ($product->id != '') {
            $orderProduct = new stdClass();
            $orderProduct->order_id = $order_id;
            $orderProduct->product_id = $product->id;
            $orderProduct->sku = $product->sku;
            $orderProduct->description = $product->description;
            $orderProduct->brand = $product->brand;
            $orderProduct->title = $product->title;
            $orderProduct->real_price = $product->real_price;
            $orderProduct->price = $product->price;
            $orderProduct->payload = $product->payload;
            $orderProduct->quantity = $quantity;
            $db->insertObject($this->orderProductsTable, $orderProduct);
        }
    }

    public function createOrder($params){
        $products = JModelLegacy::getInstance('Product', 'WishlistModel');
        $product = $products->getProduct($params);

        $total = $product->price * $params['amount'];

        $db = $this->getDbo();
        $id = 0;
        $user = JFactory::getUser()->id;
        $order = new stdClass();
        $order->user_id = $params['user'];
        $order->created_by_id = $user;
        $order->total = $total;
        $order->revision = $params['revision'];

        $db->insertObject($this->ordersTable, $order);
        $id = $db->insertid();

        $this->createOrderProducts($params, $id, $params['amount']);

        $param = array(
            'user_id' => $params['user'],
            'amount' => $total * -1,
            'type' => $params['type'],
            'correlation_id' => $id
        );
        $transaction = JModelLegacy::getInstance('Transaction', 'WishlistModel');
        $transaction->insertTransactions($param);
        return $id;
    }

    public function cancelOrder($id){
      $order = $this->getOrder($id);
      $date = new \DateTime('now',  
          new \DateTimeZone( 'America/Mexico_City' ));
      $now =$date->format('Y-m-d H:i:s');
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      $fields = array(
          $db->quoteName('deleted_at') . ' = ' . $db->quote($now)
      );
      $conditions = array(
          $db->quoteName('id') . ' = ' . $db->quote($id)
      );
      $query->update($db->quoteName($this->ordersTable))
      ->set($fields)->where($conditions);
      $db->setQuery($query);
      $result = $db->execute(); 

      $params = array(
          'user_id' => $order->user_id,
          'amount' => $order->total,
          'type' => 'cancellation',
          'correlation_id' => $id
      );

      $transaction = JModelLegacy::getInstance('Transaction', 'WishlistModel');
      $transaction->insertTransactions($params);

      return $result;
    }
}