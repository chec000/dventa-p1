<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CheckoutModelOrderm extends JModelLegacy
{
	protected $ordersTable = '#__core_orders';
	protected $orderProductsTable = '#__core_order_products';
	protected $productsTable = 'core_products';
	protected $orderCedisTable = '#__core_order_cedis';
	protected $orderAddressTable = '#__core_order_addressses';
	protected $cedisTable = '#__core_cedis';

	public function getProducts($orderId)
	{
		$results = array();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query
		->select(array('o.id, o.order_id, p.id, p.sku, p.title, p.file_name, o.price, o.quantity, o.price*o.quantity as total'))
		->from($db->quoteName($this->orderProductsTable, 'o')) 
		->join('INNER', $db->quoteName($this->productsTable, 'p') . ' ON (' . 
			$db->quoteName('p.id') . ' = ' . 
			$db->quoteName('o.product_id') . ')')
		->where('o.order_id = ' . $db->Quote($orderId))
		->order('p.title asc');

		$db->setQuery($query);
		$results = $db->loadObjectList();
		return $results;
	}

	public function createOrderProducts($params, $order_id, $quantity){
		$db = $this->getDbo();
		$products = JModelLegacy::getInstance('Product', 'CheckoutModel');
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
		$id = 0;
		$products = JModelLegacy::getInstance('Product', 'CheckoutModel');
		$product = $products->getProduct($params);
		$total = $product->price * $params['amount'];

		$transaction = JModelLegacy::getInstance('Transaction', 'CheckoutModel');
		$balance = $transaction->getBalance($params['user']);
		$balanceFinal = (is_null($balance->value)?0:$balance->value) - $total;

		if ($balanceFinal >= 0) {
			$db = $this->getDbo();
			$user = JFactory::getUser()->id;
			$order = new stdClass();
			$order->user_id = $params['user'];
			$order->created_by_id = $user;
			$order->total = $total;
			$order->revision = $params['revision'];

			$db->insertObject($this->ordersTable, $order);
			$id = $db->insertid();

			if (isset($params['address'])) 
				$this->createOrderAddress($params['address'], $id);

			$this->createOrderProducts($params, $id, $params['amount']);

			$param = array(
				'user_id' => $params['user'],
				'amount' => $total * -1,
				'type' => $params['type'],
				'correlation_id' => $id
			);
			$transaction->insertTransactions($param);
		}
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

		$transaction = JModelLegacy::getInstance('Transaction', 'CheckoutModel');
		$transaction->insertTransactions($params);

		return $result;
	}

	public function getOrder($id)
	{
		$results = array();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query
		->select(array('o.id, o.user_id, o.total, u.name, u.email, c.name as createdBy, o.deleted_at, o.created_at'))
		->from($db->quoteName($this->ordersTable, 'o')) 
		->join('INNER', $db->quoteName('#__users', 'u') . ' ON (' . 
			$db->quoteName('u.id') . ' = ' . 
			$db->quoteName('o.user_id') . ')')
		->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . 
			$db->quoteName('c.id') . ' = ' . 
			$db->quoteName('o.created_by_id') . ')')
		->where('o.id = ' . $db->Quote($id));

		$db->setQuery($query);
		$results = $db->loadObject();
		return $results;
	}

	public function getCedis($id)
	{
		$results = array();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query
		->select(array('cc.id, cc.names_cedis, cc.street, cc.ext_number, cc.int_number, cc.reference, cc.city, cc.location, cc.estate, cc.zip_code, cc.location as town'))
		->from($db->quoteName($this->orderCedisTable, 'oc'))
		->join('LEFT', $db->quoteName($this->cedisTable, 'cc') . ' ON (' . 
			$db->quoteName('oc.cedis_id') . ' = ' . 
			$db->quoteName('cc.id') . ')')
		->where('oc.order_id = ' . $db->Quote($id));

		$db->setQuery($query);
		return $db->loadObject();
	}


	public function getAddress($id)
	{
		$results = array();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query
		->select(array('oa.id, oa.street, oa.ext_number, oa.int_number, oa.reference, oa.city, oa.location, oa.state as estate, oa.zip_code, oa.town'))
		->from($db->quoteName($this->orderAddressTable, 'oa'))
		->where('oa.order_id = ' . $db->Quote($id));

		$db->setQuery($query);
		$results = $db->loadObject();
		return $results;
	}

	private function createOrderAddress($params, $id){
		$db = $this->getDbo();
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$orderAddress = new stdClass();
			$orderAddress->order_id = $id;
			$orderAddress->user_id = $user;
			$orderAddress->street = $params->street;
			$orderAddress->ext_number = $params->ext_number;
			$orderAddress->int_number = $params->int_number;
			$orderAddress->zip_code = $params->zip_code;
			$orderAddress->reference = $params->reference;
			$orderAddress->location = $params->location;
			$orderAddress->city = $params->city;
			$orderAddress->town = $params->town;
			$orderAddress->state = $params->estate;
			$db->insertObject($this->orderAddressTable, $orderAddress);
		}
	}
}