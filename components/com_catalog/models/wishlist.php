<?php
defined('_JEXEC') or die;

class CatalogModelWishlist extends JModelLegacy
{

	protected $listTable = '#__core_user_wishlist_items';

	public function itemExists($product_id){
		$list = $this->getListItem($product_id);
		return empty($list)?false:true;
	}

	public function getListItem($product_id)
	{
		$results = array();
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$productModel = JModelLegacy::getInstance('Products', 'CatalogModel');
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('U.id', 'U.title', 'U.sku, j.quantity, 
				U.file_name, U.price, j.quantity*U.price as lineTotal, j.product_id'))
			->from($db->quoteName($this->listTable, 'j'))
			->where('j.user_id = ' . $db->Quote($user))
			->where('j.product_id = ' . $db->Quote($product_id))
			->order($db->quoteName('U.title') . ' ASC');

			$query =  $productModel->setProduct($query, $db);

			$db->setQuery($query);

			$results = $db->loadObject();

			if (!empty($results)) {
				$price = $productModel->getRolesPrice($product_id ,$db);
				if (!is_null($price)){
					$results->price = $price;
					$results->lineTotal = $results->price * $results->quantity;
				}
			}
		}
		return $results;
	}
}