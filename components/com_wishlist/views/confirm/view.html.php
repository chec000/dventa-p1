<?php
defined('_JEXEC') or die('Restricted access');

class WishlistViewConfirm extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->load_assets();
		$this->userId = JFactory::getUser()->id;
		$this->order_id = 0;
		if ($this->userId > 0) {
			$this->saveSurvey($this->survey);
			$products = $this->getProductsId();
			$wishList = $this->getWishList($products);
			$balance_final = $this->getBalanceFinal($wishList);
			if ($balance_final >= 0) {
				$this->order_id = $this->createOrder($wishList);
				if ($this->order_id > 0) {
					$this->createAdcinemaItem($wishList['items']);
					$this->notificationStatus = $this->sendNotification($this->order_id);
				}
			}
		}
		parent::display();
	}

	public function getProductsId()
	{
		$products = '';
		$products = isset($this->survey['products'])?$this->survey['products']:'';
		if ($products != '') {
			$products = isset($this->checkoutProducts)?$this->checkoutProducts:null;
		}
		return $products;
	}

	public function sendNotification($orderId)
	{
		$status = false;
		$notification_type = WishlistHelper::getConfigParams('system.notifications');
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

	public function getUserProfile($key)
	{
		$user = JModelLegacy::getInstance('User', 'WishlistModel');
		$user_profile = $user->getProfileByKey(JFactory::getUser()->id, $key);
		return isset($user_profile->profile_value)?trim($user_profile->profile_value, '"'):'';
	}

	public function getSMSConfig()
	{
		$configs =JModelLegacy::getInstance('Config', 'WishlistModel');
		return array(
			'url' => is_null($configs->getConfig('pmr.sms.url'))?'':$configs->getConfig('pmr.sms.url')->value,
			'client' => is_null($configs->getConfig('pmr.sms.client'))?'':$configs->getConfig('pmr.sms.client')->value,
			'mail' => is_null($configs->getConfig('pmr.sms.mail'))?'':$configs->getConfig('pmr.sms.mail')->value,
			'password' => is_null($configs->getConfig('pmr.sms.password'))?'':$configs->getConfig('pmr.sms.password')->value,
			'ivr' => is_null($configs->getConfig('pmr.sms.ivr'))?'':$configs->getConfig('pmr.sms.ivr')->value
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

		if ($wsdl_url != '' && $idClient != '' && $email != '' && $password != '' && $phone != '' && $ivr != '') {
			$cliente = new SoapClient(
				$wsdl_url, 
				array('cache_wsdl' => 0,)
			);
			$type = 'SMS'; 
			$message = 'Tu código es: '.$orderId;
			$status = $cliente->EnviaMensajeOL($idClient, $email, $password, $type, $phone, $message, $ivr);
			if ($status > 0)
				$status = true;
		}

		return $status;
	}

	public function sendMail($orderId)
	{
		$send = false;
		if ($orderId > 0) {
			$params = WishlistHelper::setEmailParams($orderId);
			$send = WishlistHelper::sendMailOrder($params);
		}
		return $send;
	}

	public function getAdcinemaSkus()
	{
		$config = WishlistHelper::getComponentParams('com_catalog','motivale_skus');
		$sku_array = (array)json_decode($config);
		$skus = isset($sku_array['motivale'])?$sku_array['motivale']:null;
		return $skus;
	}

	public function createAdcinemaItem($list)
	{
		$skus = $this->getAdcinemaSkus();
		if (!is_null($skus)) {
			$adcinema = JModelLegacy::getInstance('Adcinema', 'WishlistModel');
			foreach ($list as $item) {
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

	public function getWishList($products)
	{
		$listModel = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
		$list = $listModel->getListItemsByProducts($products);
		return $list;
	}

	public function createOrder($products)
	{
		$order = JModelLegacy::getInstance('Order', 'WishlistModel');
		$params = array(
			'products' => $products,
			'revision' => 1,
			'type' => 'order'
		);
		return $order->createOrder($params);
	}

	public function getBalanceFinal($wishList)
	{
		$balance_final = 0;
		$totals = $wishList['lineTotals'];
		if ($totals === 0) {
			$balance_final = -1;
		}
		else{
			$trans = JModelLegacy::getInstance('Transaction', 'WishlistModel');
			$balance = is_null($trans->getBalance()->value)?0:$trans->getBalance()->value;
			$balance_final = $balance - $totals;
		}
		return $balance_final;
	}

	public function saveSurvey($data)
	{
		$surveyModel = JModelLegacy::getInstance('Survey', 'WishlistModel');
		$survey['q1'] = isset($data['q1'])?$data['q1']:null;
		$survey['q2'] = isset($data['q2'])?$data['q2']:null;
		$survey['q3'] = isset($data['q3'])?$data['q3']:null;
		$survey['q4'] = isset($data['q4'])?$data['q4']:null;
		$survey['q5'] = isset($data['q5'])?$data['q5']:null;
		$survey['q6'] = isset($data['q6'])?$data['q6']:null;
		$survey['q7'] = isset($data['q7'])?$data['q7']:null;
		$survey['q8'] = isset($data['q8'])?$data['q8']:null;
		$surveyModel->saveSurvey($survey);
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('com_confirm.css', 'com_wishlist');
		$js = $this->_getJSPath('com_confirm.js', 'com_wishlist');
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