<?php
defined('_JEXEC') or die;

class CatalogModelLike extends JModelLegacy
{

	protected $likeTable = '#__core_user_products_likes';

	public function getLike($product_id)
	{
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('l.id', 'l.user_id', 'l.product_id, l.option, l.created_at'))
			->from($db->quoteName($this->likeTable, 'l'))
			->where('l.user_id = ' . $db->Quote($user))			
			->where('l.product_id = ' . $db->Quote($product_id));

			$db->setQuery($query);
			$results = $db->loadObject();
			return $results;
		}
	}

	public function setLike($product_id, $option){
		$validOption = false;
		$user = JFactory::getUser()->id;
		$exists = $this->exists($product_id);
		$products = JModelLegacy::getInstance('Products', 'CatalogModel');
		$product = $products->getProduct($product_id);

		if (!$exists && $user > 0 && !is_null($product)) {
			$like = new stdClass();
			$like->user_id = $user;
			$like->product_id = $product_id;
			$like->option = $option;

			$result = JFactory::getDbo()
			->insertObject($this->likeTable, $like);
		}
	}

	public function exists($product_id){
		$like = $this->getLike($product_id);
		return empty($like)?false:true;
	}
}