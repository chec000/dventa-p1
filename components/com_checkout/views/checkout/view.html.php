<?php
defined('_JEXEC') or die('Restricted access');

class checkoutViewcheckout extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();
		$this->order_id = 0;
		$this->erroMsg = '';
		$userId = JFactory::getUser()->id;
		if($userId > 0){
			$checkoutStatus = CheckoutHelper::getCheckoutState();
			$this->erroMsg .= ($checkoutStatus)?'':$this->getErrorMessages('checkoutState');

			$configs = $this->getModel('Config');
			$delivery_mode = 
			is_null($configs->getConfig('checkout.delivery.mode'))?
			null:$configs->getConfig('checkout.delivery.mode')->value;

			$cart = $this->getModel('Cart');
			$cart_total = $cart->getCartItems();

			$balance_final = $this->getBalance($cart_total);
			$this->erroMsg .= ($balance_final>=0)?'':$this->getErrorMessages('points');
			
			$stock = $this->getStocks($cart_total['items']);
			$this->erroMsg .= ($stock)?'':$this->getErrorMessages('stock');

			$enabled = $this->getProductsEnabled($cart_total['items']);
			$this->erroMsg .= ($enabled)?'':$this->getErrorMessages('activeProducts');

			$this->delivery_info = $this->getDeliveryInfo($delivery_mode, $this->delivery);
			if ($this->delivery_info['id'] == '' || $this->delivery_info['userId'] == '') {
				JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_checkout', false));
			}
			
			$insert = $this->canInsert($delivery_mode, $this->delivery);
			$this->erroMsg .= ($insert)?'':$this->getErrorMessages('noAddress');

			if ($insert && $balance_final >= 0 && $checkoutStatus && $stock && $enabled) {
				$this->delivery_info['revision'] = 1;
				$order = $this->getModel('Checkout');
				$this->saveBalance($cart_total['lineTotals']);
				$this->order_id = $order->createOrder($this->delivery_info);
				if ($this->order_id > 0){
					$this->createAdcinemaItem($cart_total['items']);
					$this->updateStock($cart_total['items']);
					$this->notificationStatus = $this->sendNotification($this->order_id);
				}
			}
		}
		else{
			$this->userId = $userId;
		}
		parent::display();
	}

	public function getErrorMessages($type)
	{
		switch ($type) {
			case 'stock':
			return JText::_('COM_CHECKOUT_STOCK_LACK')."\n";
			break;
			
			case 'points':
			return JText::_('COM_CHECKOUT_POINTS_FEW')."\n";
			break;

			case 'checkoutState':
			return JText::_('COM_CHECKOUT_CHECKOUT_DISABLED')."\n";
			break;

			case 'activeProducts':
			return JText::_('COM_CHECKOUT_PRODUCTS_UNABLED')."\n";
			break;

			case 'noAddress':
			return JText::_('COM_CHECKOUT_ADDRESS_MISSED')."\n";
			break;
		}
	}

	public function createAdcinemaItem($cart)
	{
		$skus = $this->getAdcinemaSkus();
		if (!is_null($skus)) {
			$adcinema = $this->getModel('Adcinema');
			foreach ($cart as $item) {
				$type = $this->getInObject($skus, $item->sku);
				if ($type != '') {
					$params['quantity'] = $item->quantity;
					$params['type'] = $type;
					$adcinema->insertItem($params);
				}
			}
		}
	}

	public function getInObject($object, $value)
	{
		foreach ($object as $val) {
			if ($val->sku === $value) {
				return $val->type;
			}
		}
	}

	public function getAdcinemaSkus()
	{
		$config = CheckoutHelper::getComponentParams('com_catalog','motivale_skus');
		$sku_array = (array)json_decode($config);
		$skus = isset($sku_array['motivale'])?$sku_array['motivale']:null;
		return $skus;
	}

	public function getStocks($cart)
	{
                if($this->hasCheckoutWithoutStock()){
                    return true;
                }
		$stock = false;
		foreach ($cart as $item) {
			$stock_amount = $this->getStock($item->id);
			$newStock = $stock_amount - $item->quantity;
			if ($newStock >= 0)
				$stock = true;
			else
				return false;
		}
		return $stock;
	}

        public function hasCheckoutWithoutStock()
        {
            $isCheckoutWithoutStock = false;
            $configs =JModelLegacy::getInstance('Config', 'CheckoutModel');
            if(!is_null($configs->getConfig('checkout.soft'))){
                $isCheckoutWithoutStock = $configs->getConfig('checkout.soft')->value==='1'?true:false;
            }
            return $isCheckoutWithoutStock;
        }        

        public function getProductsEnabled($cart)
	{
		$enabled = true;
		foreach ($cart as $item) {
			if ($item->enabled == 0)
				return false;
		}
		return $enabled;
	}

	public function getStock($product_id)
	{
		$stock = $this->getModel('Stock');
		$stock_amount = is_null($stock->getStock($product_id))?
		'0':$stock->getStock($product_id)->stock;
		return $stock_amount;
	}

	public function updateStock($cart)
	{
		$stock = $this->getModel('Stock');
		foreach ($cart as $item) {
			$params['quantity'] = $item->quantity;
			$params['product_id'] = $item->id;
			$stock->updateStock($params);
		}
	}

	public function sendNotification($orderId)
	{
		$status = false;
		$notification_type = CheckoutHelper::getConfigParams('system.notifications');
		switch (strtolower($notification_type)) {
			case "sms":
			$status = $this->sendSMS($orderId);
			break;
			case "email":
			$status = $this->sendMail($orderId);
			break;
			case "users":
			$user_notification_type = strtolower($this->getUserProfile('profile.notifications_mode'));
			if ($user_notification_type == 'email')
				$status = $this->sendMail($orderId);
			if ($user_notification_type == 'sms')
				$status = $this->sendSMS($orderId);
			break;
		}
		return $status;
	}

	public function getSMSConfig()
	{
		$configs =JModelLegacy::getInstance('Config', 'CheckoutModel');
		return array(
			'url' => is_null($configs->getConfig('pmr.sms.url'))?'':$configs->getConfig('pmr.sms.url')->value,
			'client' => is_null($configs->getConfig('pmr.sms.client'))?'':$configs->getConfig('pmr.sms.client')->value,
			'mail' => is_null($configs->getConfig('pmr.sms.mail'))?'':$configs->getConfig('pmr.sms.mail')->value,
			'password' => is_null($configs->getConfig('pmr.sms.password'))?'':$configs->getConfig('pmr.sms.password')->value,
			'ivr' => is_null($configs->getConfig('pmr.sms.ivr'))?'':$configs->getConfig('pmr.sms.ivr')->value,
			'messagep1' => is_null($configs->getConfig('pmr.sms.messagep1'))?'':$configs->getConfig('pmr.sms.messagep1')->value,
			'messagep2' => is_null($configs->getConfig('pmr.sms.messagep2'))?'':$configs->getConfig('pmr.sms.messagep2')->value
		);
	}

	public function sendSMS($orderId)
	{
		$status = false;
		$phone = $this->getUserProfile('profile.num_cel');

		$smsConfig = $this->getSMSConfig();
		$wsdl_url = $smsConfig['url'];
		$idClient = $smsConfig['client'];
		$email = $smsConfig['mail'];
		$password = $smsConfig['password'];
		$ivr = $smsConfig['ivr'];
		$messagep1 = $smsConfig['messagep1'];
		$messagep2 = $smsConfig['messagep2'];

		if ($wsdl_url != '' && $idClient != '' && $email != '' && $password != '' && $phone != '' && $ivr != '') {
			$cliente = new SoapClient(
				$wsdl_url,
				array('cache_wsdl' => 0)
			);
			$type = 'SMS';
			$message = $messagep1.' '.$orderId.' '.$messagep2;
			$status = $cliente->EnviaMensajeOL($idClient, $email, $password, $type, $phone, $message, $ivr);
			if ($status > 0){
				$status = true;
			}
		}
		return $status;
	}

	public function sendMail($orderId)
	{
		$send = false;
		if ($orderId > 0) {
			$params = CheckoutHelper::setEmailParams($orderId);
			$send = CheckoutHelper::sendMailOrder($params);
		}
		return $send;
	}

	public function getUserProfile($key)
	{
		$user = JModelLegacy::getInstance('User', 'CheckoutModel');
		$user_profile = $user->getProfileByKey(JFactory::getUser()->id, $key);
		return isset($user_profile->profile_value)?trim($user_profile->profile_value, '"'):'';
	}

	public function saveBalance($amount)
	{
		$trans = $this->getModel('Transactions');
		$trans->insertTransactions($amount);
	}

	public function getBalance($cart)
	{
		$balance_final = 0;
		$trans = $this->getModel('Transactions');
		$balance = is_null($trans->getBalance()->value)?0:$trans->getBalance()->value;
		$balance_final = $balance - $cart['lineTotals'];
		return $balance_final;
	}

	public function canInsert($delivery_mode, $delivery)
	{
		$insert = false;
		if ($delivery_mode == 'user-address') {
			if (isset($delivery['street'])) {
				$insert = true;
			}
		}
		else
		{
			if (isset($delivery['cedisId'])) {
				if ($delivery['cedisId'] != '') {
					$insert = true;
				}
			}
		}

		return $insert;
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
				if ($cedis->id != '') {
					$delivery_info = array(
						'id' => $cedis->id,
						'cedis' =>$cedis->names_cedis,
						'street' => $cedis->street,
						'extNum' => $cedis->ext_number,
						'intNum' => $cedis->int_number,
						'location' => $cedis->location,
						'reference' => $cedis->reference,
						'state' => $cedis->estate,
						'city' => $cedis->city,
						'zip_code' => $cedis->zip_code,
						'town' => '',
						'userId' => 'N/A'
					);
				}
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
		$css = $this->_getCSSPath('checkout.css', 'com_checkout');
		$js = $this->_getJSPath('checkout.js', 'com_checkout');
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