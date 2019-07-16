<?php
defined('_JEXEC') or die;

class CheckoutModelCheckout extends JModelLegacy
{
	protected $ordersTable = '#__core_orders';
	protected $orderCedisTable = '#__core_order_cedis';
	protected $orderAddressTable = '#__core_order_addressses';
	protected $orderProductsTable = '#__core_order_products';
	protected $cartTable = '#__core_user_cart_items';
	protected $productTable = 'core_products';
	protected $ProductxRoleTable = 'core_products_x_roles';
	protected $productsTable = 'core_products';
	protected $cedisTable = '#__core_cedis';

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
		->where('o.order_id = ' . $db->Quote($orderId));

		$db->setQuery($query);
		$results = $db->loadObjectList();
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
		$results = $db->loadObject();
		return $results;
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

	public function createOrder($params){
		$db = JFactory::getDbo();
		$id = 0;
		$user = JFactory::getUser()->id;
		$insert = $this->canInsert($params);
		if ($user > 0) {
			$params['products'] = $this->getCartItems();
			if (!empty($params['products']['items']) && $insert) {
				$order = new stdClass();
				$order->user_id = $user;
				$order->created_by_id = $user;
				$order->total = $params['products']['lineTotals'];
				$order->revision = $params['revision'];

				$db->insertObject($this->ordersTable, $order);
				$id = $db->insertid();

				if (isset($params['id']) && $params['id'] != 'N/A' ) 
					$this->createOrderCedis($params, $id);
				else
					$this->createOrderAddress($params, $id);
				
				$this->createOrderProducts($params['products']['items'], $id);
			}
		}
		return $id;
	}

	private function canInsert($params){
		$insert = false;
		$cedis = isset($params['id'])?true:false;

		if ($cedis && $params['id'] == '')
			$insert = false;
		else
			$insert = true;

		if (!$cedis)
			$insert = true;

		return $insert;
	}

	private function createOrderCedis($params, $id){
		$db = JFactory::getDbo();
		if ($params['id'] != '') {
			$orderCedis = new stdClass();
			$orderCedis->cedis_id = $params['id'];
			$orderCedis->order_id = $id;
			$db->insertObject($this->orderCedisTable, $orderCedis);
		}
	}

	private function createOrderAddress($params, $id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser()->id;
		if ($user > 0) {
		
			$orderAddress = new stdClass();
			$orderAddress->order_id = $id;
			$orderAddress->user_id = $user;
			$orderAddress->street = $params['street'];
			$orderAddress->ext_number = $params['num_ext'];
			$orderAddress->int_number = $params['num_int'];
			$orderAddress->zip_code = $params['zip_code'];
			$orderAddress->reference = $params['reference'];
			$orderAddress->location = $params['location'];
			$orderAddress->city = $params['city'];
			$orderAddress->town = $params['town'];		
			$orderAddress->state = $params['state'];
			$orderAddress->phone = $params['phone'];
			$orderAddress->cellphone = $params['cellphone'];
			$orderAddress->between_street1 = $params['between_street1'];
			$orderAddress->between_street2 = $params['between_street2'];
			$db->insertObject($this->orderAddressTable, $orderAddress);
		}
	}

	private function createOrderProducts($params, $id){
		$db = JFactory::getDbo();
		foreach ($params as $product) {
			if ($product->id != '') {
				$orderAddress = new stdClass();
				$orderAddress->order_id = $id;
				$orderAddress->product_id = $product->id;
				$orderAddress->sku = $product->sku;
				$orderAddress->description = $product->description;
				$orderAddress->brand = $product->brand;
				$orderAddress->title = $product->title;
				$orderAddress->real_price = $product->real_price;
				$orderAddress->price = $product->price;
				$orderAddress->payload = $product->payload;
				$orderAddress->quantity = $product->quantity;
				$db->insertObject($this->orderProductsTable, $orderAddress);
				$this->deleteCartItem($product->id);
			}
		}
	}

	public function getCartItems(){
		$results = array();
		$user = JFactory::getUser()->id;

		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('b.id', 'b.title', 'b.sku, a.quantity, a.product_id, 
				b.file_name, b.price, a.quantity*b.price as lineTotal, b.description, 
				b.brand, b.real_price, b.payload'))
			->from($db->quoteName($this->cartTable, 'a'))
			->join('INNER', $db->quoteName($this->productTable, 'b') . ' ON (' . 
				$db->quoteName('a.product_id') . ' = ' . 
				$db->quoteName('b.id') . ')')
			->where('a.user_id = ' . $db->Quote($user))
			->where('b.enabled = 1')
			->order($db->quoteName('b.title') . ' ASC');

			$db->setQuery($query);

			$results = $db->loadObjectList();

			if (!empty($results)) {
				foreach ($results as $product) {
					$price = $this->getRolesPrice($product->product_id ,$db);
					if (!is_null($price)){
						$product->price = $price;
						$product->lineTotal = $product->price * $product->quantity;
					}
				}
			}

			$total = 0;
			foreach ($results as $item){
				$total += $item->lineTotal;
			}

			$results['items'] = $results;
			$results['lineTotals'] = $total;
		}

		return $results;
	}

	private function deleteCartItem($id){
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$conditions = array(
				$db->quoteName('user_id') . ' = ' . $db->quote($user), 
				$db->quoteName('product_id') . ' = ' . $db->quote($id)
			);

			$query->delete($db->quoteName($this->cartTable));
			$query->where($conditions);

			$db->setQuery($query);

			$result = $db->execute();
		}
	}

	public function getRolesPrice($product_id, $db){
		$results = null;
		$price = null;
		$roles = CheckoutHelper::getRoles();
		foreach ($roles['array'] as $rol) {
			$queryRoles = $db->getQuery(true);
			$queryRoles
			->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
			->from($db->quoteName($this->ProductxRoleTable, 'PXR'))
			->where('PXR.rol_id = ' . $db->Quote($rol))
			->where('PXR.product_id = ' . $db->Quote($product_id));

			$db->setQuery($queryRoles);
			$results = $db->loadObject();
			if (!is_null($results)) {
				$price = $results->price;
			}
		}
		return $price;
	}
}