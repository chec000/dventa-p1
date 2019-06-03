<?php
defined('_JEXEC') or die;

class CheckoutModelCheckout_State extends JModelLegacy
{
	protected $checkoutStatusTable = '#__core_checkout_x_roles';

	public function getCheckoutStatus($roles){
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('c.id, c.rol_id, c.start_date, c.end_date, c.created_at, c.updated_at'))
			->from($db->quoteName($this->checkoutStatusTable, 'c'))
			->where($db->quoteName('c.rol_id').' IN ' . '('.$roles.')');

			$db->setQuery($query);

			$results = $db->loadObjectList();
			return $results;
		}
	}
}