<?php
defined('_JEXEC') or die('Restricted access');

class cartViewcart extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();
		$this->checkoutStatus = CartHelper::getCheckoutState();
		$this->params = isset($this->params)?$this->params:null;

		$this->items = array();
		$userId = JFactory::getUser()->id;
		$this->currency = $this->getCurrency();

		if($userId > 0){
			$this->cartOperations($this->params);
			$cart = $this->getModel('Cart');
			$cart_data = $cart->getCartItems();
			$this->items = $cart_data['items'];
			$this->lineTotals = $cart_data['lineTotals'];
			$this->showPrice = $this->getPriceShow();
			$balance_final = $this->getBalance($cart_data);
			if ($balance_final >= 0) 
				$this->balance = true;
			else
				$this->balance = false;
		}
		else{
			$this->userId = $userId;
		}

		parent::display();
	}

	public function getPriceShow()
	{
		$configs = JModelLegacy::getInstance('Cart', 'CartModel');
		$value = is_null($configs->getConfig('catalog.productprice.show'))?'0':$configs->getConfig('catalog.productprice.show')->value;
		return $value;
	}

	public function getBalance($cart)
	{
		$balance_final = 0;
		$trans = $this->getModel('Transactions');
		$balance = is_null($trans->getBalance()->value)?0:$trans->getBalance()->value;
		$balance_final = $balance - $cart['lineTotals'];
		return $balance_final;
	}

	public function getCurrency()
	{
		$configs = $this->getModel('Cart');
		$currency = is_null($configs->getConfig('pmr.coin.name'))?"":$configs->getConfig('pmr.coin.name')->value;
		return $currency;
	}

	public function cartOperations($params)
	{
		$operation = $params['operation'];

		switch ($operation) {
			case 'delete':
			$this->deleteCartItem($params);
			break;
			case 'update':
			$this->updateCartItem($params);
			break;
			case 'empty':
			$this->emptyCart();
			break;
			case 'create':
			$this->createCart($params);
			break;
		}
	}

	public function deleteCartItem($params)
	{	
		if (!is_null($params['id'])) {
			$cart = $this->getModel('Cart');
			$cart->deleteCartItem($params);
		}
	}	

	public function updateCartItem($params)
	{
		if (!is_null($params['id']) && $params['quantity'] > 0) {
			$cart = $this->getModel('Cart');
			$cart->updateCartItem($params);
		}
	}

	public function emptyCart()
	{
		$cart = $this->getModel('Cart');
		$cart->emptyCart();
	}

	public function createCart($params)
	{
		if ($this->checkoutStatus) {
			$cart = $this->getModel('Cart');
			$cart->createCart($params);
		}
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('com_cart.css', 'com_cart');
		$js = $this->_getJSPath('com_cart.js', 'com_cart');
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