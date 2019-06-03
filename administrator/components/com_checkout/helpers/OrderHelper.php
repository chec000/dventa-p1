<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class OrderHelper
{
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_checkout';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	private static function sendMailBody($body, $subject, $mail)
	{
		$send = false;
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get('mailfrom'),
			$config->get('fromname') 
		);

		$mailer->setSender($sender);
		$mailer->addRecipient($mail);
		$mailer->setSubject($subject);

		$mailer->isHtml(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);
		$send = $mailer->Send();
		return $send;
	}

	public static function sendMailOrder($params)
	{
		$status = false;
		$body = self::buildEmailTemplate($params);
		if ($body == '') {
			$body = '<div>Este es su numero de canje: ' . $params['id']
			. '</div>';
		}
		$subject = JText::_('COM_CHECKOUT_MAIL_SUBJECT');
		if ($params['email'] != '') {
			$status = self::sendMailBody($body, $subject, trim($params['email']));
		}
		return $status;
	}

	public static function buildEmailTemplate($params)
	{
		$template = '';
		$notification = JModelLegacy::getInstance('Notification','CheckoutModel');
		$html = is_null($notification->getTemplae('com_checkout'))
		?null:$notification->getTemplae('com_checkout')->value;

		ob_start();
		$template = eval('$data=$params ?>' . $html);
		$template .= ob_get_clean();

		return $template;
	}

	public static function setEmailParams($id)
	{
		$config = self::getComponentParams('com_checkout', 'profile_info');
		$orders = JModelLegacy::getInstance('Orderm', 'CheckoutModel');
		$order = $orders->getOrder($id);

		if ($config == '1') {
			$params['profile'] = self::completeUserProfileFromInfo($order->user_id, $id);
		}
		else{
			$params['profile'] = self::completeUserProfileFromProfile($order->user_id);
		}

		$params['date'] = $order->created_at;
		$params['email'] = JFactory::getUser($order->user_id)->email;
		$params['id'] = $id;
		$params['user'] = JFactory::getUser($order->user_id);
		$params['items'] = $orders->getProducts($id);
		$params['total'] = $order->total;
		$cedis = $orders->getCedis($id);
		$address = $orders->getAddress($id);
		$delivery = null;
		if (!is_null($cedis))
			$delivery = $cedis;

		if (!is_null($address))
			$delivery = $address;

		if (is_null($delivery)) {
			$delivery = self::getUserAddress($order->user_id);
		}
		$params['details'] = $delivery;
		$params['details']->names_cedis = isset($cedis->names_cedis)?$cedis->names_cedis:'N/A';
		return $params;
	}

	public static function getUserAddress($user)
	{
		$delivery = new stdClass();
		$delivery->street = self::getUserProfile('profile.street', $user);
		$delivery->ext_number = self::getUserProfile('profile.num_ext', $user);
		$delivery->int_number = self::getUserProfile('profile.num_int', $user);
		$delivery->reference = self::getUserProfile('profile.reference', $user);
		$delivery->city = self::getUserProfile('profile.city', $user);
		$delivery->town = self::getUserProfile('profile.town', $user);
		$delivery->location = self::getUserProfile('profile.neighborhood', $user);
		$delivery->estate = self::getUserProfile('profile.estate', $user);
		$delivery->zip_code = self::getUserProfile('profile.postal_code', $user);
		return $delivery;
	}

	public static function completeUserProfileFromInfo($user, $orderId)
	{
		$orders = JModelLegacy::getInstance('Orderm', 'CheckoutModel');
		$cedis = $orders->getCedis($orderId);
		$info = self::getUserInfo($user);

		$profile = new stdClass();
		$profile->last_name = isset($info->lastname)?$info->lastname:'';
		$profile->city = isset($cedis->city)?$cedis->city:'N/A';
		$profile->estate = isset($cedis->estate)?$cedis->estate:'N/A';
		$profile->num_cel = isset($info->cellphone)?$info->cellphone:'';
		$profile->num_tel = isset($info->telephone)?$info->telephone:'';
		return $profile;
	}

	public static function completeUserProfileFromProfile($user)
	{
		$profile = new stdClass();
		$profile->last_name1 = self::getUserProfile('profile.last_name1', $user);
		$profile->last_name2 = self::getUserProfile('profile.last_name2', $user);
		$profile->last_name = $profile->last_name1 . ' ' . $profile->last_name2;
		$profile->city = self::getUserProfile('profile.city', $user);
		$profile->estate = self::getUserProfile('profile.estate', $user);
		$profile->num_cel = self::getUserProfile('profile.num_cel', $user);
		$profile->num_tel = self::getUserProfile('profile.num_tel', $user);
		return $profile;
	}

	public static function getUserProfile($key, $user)
	{
		$userModel = JModelLegacy::getInstance('User', 'CheckoutModel');
		$user_profile = $userModel->getProfileByKey($user, $key);
		return isset($user_profile->profile_value)?trim($user_profile->profile_value, '"'):'';
	}

	public static function getUserInfo($user)
	{
		$userModel = JModelLegacy::getInstance('User', 'CheckoutModel');
		return $userModel->getProfileInfo($user);
	}

	public static function getConfigParams($key)
	{
		$configs = JModelLegacy::getInstance('Config', 'CheckoutModel');
		return is_null($configs->getConfig($key))?null:$configs->getConfig($key)->value;
	}

	public static function getSMSConfig()
	{
		$configs =JModelLegacy::getInstance('Config', 'CheckoutModel');
		return array(
			'url' => is_null($configs->getConfig('pmr.sms.url'))?'':$configs->getConfig('pmr.sms.url')->value,
			'client' => is_null($configs->getConfig('pmr.sms.client'))?'':$configs->getConfig('pmr.sms.client')->value,
			'mail' => is_null($configs->getConfig('pmr.sms.mail'))?'':$configs->getConfig('pmr.sms.mail')->value,
			'password' => is_null($configs->getConfig('pmr.sms.password'))?'':$configs->getConfig('pmr.sms.password')->value,
			'ivr' => is_null($configs->getConfig('pmr.sms.ivr'))?'':$configs->getConfig('pmr.sms.ivr')->value
		);
	}

	public static function sendMail($orderId)
	{
		$send = false;
		if ($orderId > 0) {
			$params = self::setEmailParams($orderId);
			$send = self::sendMailOrder($params);
		}
		return $send;
	}

	public static function sendSMS($orderId, $userId)
	{
		$status = false;
		$phone = self::getUserProfile('profile.num_cel', $userId);

		$smsConfig = self::getSMSConfig();
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

	public static function getComponentParams($component, $key)
	{
		$params = JComponentHelper::getParams($component);
		return  $params[$key];
	}
}