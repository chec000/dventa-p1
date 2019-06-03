<?php
defined('_JEXEC') or die;

class WishlistModelOrder extends JModelLegacy
{
	protected $ordersTable = '#__core_wishlist_orders';
	protected $orderProductsTable = '#__core_wishlist_order_products';

	public function createOrder($params){
		$user = JFactory::getUser()->id;
		$id = 0;
		$products = $params['products'];
		if ($user > 0 && !empty($products)) {
			$total = $products['lineTotals'];
			$db = JFactory::getDbo();
			$user = JFactory::getUser()->id;
			$order = new stdClass();
			$order->user_id = $user;
			$order->created_by_id = $user;
			$order->total = $total;
			$order->revision = $params['revision'];

			$db->insertObject($this->ordersTable, $order);
			$id = $db->insertid();

			$transactionParams = array(
				'user_id' => $user,
				'amount' => $total * -1,
				'type' => $params['type'],
				'correlation_id' => $id
			);
			$transaction = JModelLegacy::getInstance('Transaction', 'WishlistModel');
			$transaction->insertTransactions($transactionParams);

			$stock = JModelLegacy::getInstance('Stock', 'WishlistModel');
			foreach ($products['items'] as $item) {
				$stockParams['quantity'] = $item->quantity;
				$stockParams['product_id'] = $item->id;
				$stock->updateStock($stockParams);
			}

			$Wishlist = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
			foreach ($products['items'] as $product) {
				$this->createOrderProducts($product->id ,$id, 1);
				$Wishlist->deleteListItem($product->id);
			}
		}
		return $id;
	}

	public function createOrderProducts($product_id, $order_id, $quantity){
		$db = $this->getDbo();
		$products = JModelLegacy::getInstance('Product', 'WishlistModel');
		$product = $products->getProduct($product_id);
		if (!is_null($product)) {
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
}