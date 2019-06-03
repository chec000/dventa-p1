<?php
defined('_JEXEC') or die('Restricted access');

class CheckoutViewDelivery extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->saveSurvey($this->survey);

		$this->load_assets();

		$userId = JFactory::getUser()->id;
		if($userId > 0){
			$configs = $this->getModel('Config');
			$this->delivery = 
			is_null($configs->getConfig('checkout.delivery.mode'))?
			null:$configs->getConfig('checkout.delivery.mode')->value;
			$deliveryModel = $this->getModel('Delivery');
			$this->cedis_list = $deliveryModel->getCedisList();
			$this->cedis = $this->getUserCedis($this->params['cedis'], $deliveryModel);
			$this->address = $this->getUserAddress();
			$this->states = $this->getStates();
		}
		else{
			$this->userId = $userId;
		}

		$edit = CheckoutHelper::getComponentParams('com_checkout', 'delivery_edit');
		$edit = (is_null($edit) || $edit == "1")?true:false;
		$this->editDelivery = $edit;

		parent::display();
	}

	public function getUserAddress()
	{
		$address = new stdClass();
		$address->street = $this->getUserProfile('profile.street');
		$address->num_ext = $this->getUserProfile('profile.num_ext');
		$address->num_int = $this->getUserProfile('profile.num_int');
		$address->reference = $this->getUserProfile('profile.reference');
		$address->postal_code = $this->getUserProfile('profile.pc');
		$address->neighborhood = $this->getUserProfile('profile.neighborhood');
		$address->city = $this->getUserProfile('profile.city');
		$address->town = $this->getUserProfile('profile.town');
		$address->estate = $this->getUserProfile('profile.estate');
		return $address;
	}

	public function getUserCedis($params, $deliveryModel)
	{
		$cedis = $deliveryModel->getCedis($params);
		if ($cedis->id == '') {
			$cedis = $deliveryModel->getCedis($this->getUserProfile('profile.names_cedis'));
			if ($cedis->id == '') {
				$cedis->estate = '';
			}
		}
		return $cedis;
	}

	public function getUserProfile($key)
	{
		$user = JModelLegacy::getInstance('User', 'CheckoutModel');
		$user_profile = $user->getProfileByKey(JFactory::getUser()->id, $key);
		return isset($user_profile->profile_value)?trim($user_profile->profile_value, '"'):'';
	}

	public function getStates()
	{
		$zipCodes = $this->getModel('Zipcode');
		$return = $zipCodes->getStates();
		return $return;
	}

	public function saveSurvey($data){
		$survey = array();
		$size = sizeof($data);
		for($i = 1; $i <= $size; $i++){
			$index = 'q'.$i;
			if(array_key_exists($index, $data)){ 
				$survey['q'.$i] = isset($data['q'.$i]) ? $data['q'.$i] : null; 
			}
		}
		$surveyModel = $this->getModel('Survey');
		$surveyModel->saveSurvey($survey);
	}

	public function load_assets()
	{
		$doc = JFactory::getDocument();
		$css = $this->_getCSSPath('delivery.css', 'com_checkout');
		$js = $this->_getJSPath('delivery.js', 'com_checkout');
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