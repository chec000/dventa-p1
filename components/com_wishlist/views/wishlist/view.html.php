<?php
defined('_JEXEC') or die('Restricted access');

class WishlistViewWishlist extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();
		$userId = JFactory::getUser()->id;
		if($userId > 0){
			$this->params = isset($this->params)?$this->params:null;
			$this->operations($this->params);
			$this->checkoutStatus = WishlistHelper::getCheckoutState();
			$this->currency = $this->getCurrency();
			$list = $this->getListItems();
			$this->items = $list['items'];
			$this->lineTotals = $list['lineTotals'];
			$this->showPrice = $this->getPriceShow();
		}
		else{
			$this->userId = $userId;
		}
		parent::display();
	}

	public function getPriceShow()
	{
		$configs = JModelLegacy::getInstance('Config', 'WishlistModel');
		$value = is_null($configs->getConfig('catalog.productprice.show'))?'0':$configs->getConfig('catalog.productprice.show')->value;
		return $value;
	}

	public function getListItems()
	{
		$list = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
		return $list->getListItems();
	}

	public function getCurrency()
	{
		$configs = JModelLegacy::getInstance('Config', 'WishlistModel');
		$currency = is_null($configs->getConfig('pmr.coin.name'))?"":$configs->getConfig('pmr.coin.name')->value;
		return $currency;
	}

	public function operations($params)
	{
		$operation = $params['operation'];

		switch ($operation) {
			case 'delete':
			$this->deleteListItem($params);
			break;
			case 'create':
			$this->createList($params);
			break;
		}
	}

	public function deleteListItem($params)
	{	
		if (!is_null($params['products'])) {
			$products = $params['products'];
			$list = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
			$list->deleteListItems($products);
		}
	}

	public function createList($params)
	{
		$list = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
		$list->createList($params);
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('com_wishlist.css', 'com_wishlist');
		$js = $this->_getJSPath('com_wishlist.js', 'com_wishlist');
		$doc->addScript($js);
		if ($css) {
			$doc->addStyleSheet($css);
		}
		if ($js) {
			$doc->addScript($js);
		}
		$doc->addStyleDeclaration($css);
	}

	public static function _getJSPath($jsfile, $component)
	{
		$bPath = 'components/' . $component . '/assets/js/' . $jsfile;
		if (file_exists(JPATH_BASE . '/' . $bPath)) {
			return JURI::Root(true) . '/' . $bPath;
		} else {
			return false;
		}
	}

	public static function _getCSSPath($cssfile, $component)
	{
		$bPath = 'components/' . $component . '/assets/css/' . $cssfile;
		if (file_exists(JPATH_BASE . '/' . $bPath)) {
			return JURI::Root(true) . '/' . $bPath;
		} else {
			return false;
		}
	}
}