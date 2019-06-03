<?php
defined('_JEXEC') or die('Restricted access');

class CheckoutViewConfirm extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();

		$userId = JFactory::getUser()->id;
		if($userId > 0){
			$this->showPrice = $this->getPriceShow();
			$configs = $this->getModel('Config');
			$this->delivery_mode = 
			is_null($configs->getConfig('checkout.delivery.mode'))?
			null:$configs->getConfig('checkout.delivery.mode')->value;

			$this->currency = $this->getCurrency();
			$cart = $this->getModel('Cart');
			$cart_data = $cart->getCartItems();
			$this->cartItems = $cart_data['items'];
			$this->lineTotals = $cart_data['lineTotals'];

			if (isset($this->delivery['cedisId'])) {
				$this->cedis = $this->loadCedis($this->delivery['cedisId']);
			}

			$this->delivery_info = $this->getDeliveryInfo($this->delivery_mode, $this->delivery);
			if ($this->delivery_info['id'] == '' || $this->delivery_info['userId'] == '') {
				JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_checkout', false));
			}
		}
		else{
			$this->userId = $userId;
		}
		parent::display();
	}

	public function getPriceShow()
	{
		$configs = JModelLegacy::getInstance('Config', 'CheckoutModel');
		$value = is_null($configs->getConfig('catalog.productprice.show'))?'0':$configs->getConfig('catalog.productprice.show')->value;
		return $value;
	}

	public function getCurrency()
	{
		$configs = $this->getModel('Config');
		$currency = is_null($configs->getConfig('pmr.coin.name'))?"":$configs->getConfig('pmr.coin.name')->value;
		return $currency;
	}

	public function getDeliveryInfo($mode, $data)
	{
		$delivery_info = array();
		if ($mode == 'user-address') {
			$delivery_info = $this->loadUser($data);
		}
		else{
			if (isset($data['cedisId'])) {
				$cedisId = $data['cedisId'];
				$cedis = $this->loadCedis($cedisId);
				$delivery_info = array(
					'id' => $cedis->id,
					'cedis' =>$cedis->names_cedis,
					'city' => $cedis->city,
					'estate' => $cedis->estate,
					'userId' => 'N/A'
				);
			}
			else
			{
				$delivery_info = array(
					'id' => '',
					'cedis' => '',
					'city' => '',
					'state' => '',
					'userId' => 'N/A'
				);
			}
		}
		return $delivery_info;
	}

	public function loadCedis($id)
	{
		$delivery = $this->getModel('Delivery');
		$cedis = $delivery->getCedis($id);
		return $cedis;
	}

	public function loadUser($data)
	{
		return array(
			'id' => 'N/A',
			'userId' => JFactory::getUser()->id,
			'street' => isset($data['street'])?$data['street']:'',
			'extNum' => isset($data['extNum'])?$data['extNum']:'',
			'intNum' => isset($data['intNum'])?$data['intNum']:'',
			'reference' => isset($data['reference'])?$data['reference']:'',
			'location' => isset($data['location'])?$data['location']:'',
			'zip_code' => isset($data['zip_code'])?$data['zip_code']:'',
			'city' => isset($data['city'])?$data['city']:'',
			'town' => isset($data['town'])?$data['town']:'',
			'state' => isset($data['state'])?$data['state']:'',
		);
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('confirm.css', 'com_checkout');
		$js = $this->_getJSPath('confirm.js', 'com_checkout');
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