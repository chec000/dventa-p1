<?php
defined('_JEXEC') or die;

class CatalogModelLike extends JModelLegacy
{

	protected $likeTable = '#__core_user_products_likes';

	public function getLike($product_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
		->select(array('l.id, l.option, l.product_id, l.user_id, l.created_at'))
		->from($db->quoteName($this->likeTable, 'l'))		
		->where('l.product_id = ' . $db->Quote($product_id));

		$db->setQuery($query);
		$results = $db->loadObjectList();
		return $results;
	}
}