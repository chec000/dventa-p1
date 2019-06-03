<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/OrderHelper.php';

class CheckoutControllerDetails extends JControllerAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getModel($name = 'detail', $prefix = 'checkoutModel', 
		$config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function back()
	{
		$this->setRedirect(JRoute::_(
			'index.php?option=com_checkout', false));  
	}

	public function cancelar()
	{
		$id = JRequest::getVar('id',  0, '');
		$model = $this->getModel('orders');
		$model->cancelar($id);
		$this->setRedirect(JRoute::_(
			'index.php?option=com_checkout&view=orders', false));
	}

	public function confirmation()
	{
		$orderId = JRequest::getVar('id',  0, '');
		if ($orderId > 0) {
			$this->processNotification($orderId);
		}
		$this->setRedirect(JRoute::_(
			'index.php?option=com_checkout&view=orders', false));
	}

	private function processNotification($orderId)
	{
		$orders = JModelLegacy::getInstance('Orderm', 'CheckoutModel');
		$order = $orders->getOrder($orderId);
		$notification_type = OrderHelper::getConfigParams('system.notifications');
		switch (strtolower($notification_type)) {
			case "sms":
			$status = OrderHelper::sendSMS($orderId, $order->user_id);
			break;
			case "email":
			$status = OrderHelper::sendMail($orderId);
			break;
			case "users":
			$user_notification_type = strtolower(OrderHelper::getUserProfile('profile.notifications_mode', $order->user_id));
			if ($user_notification_type == 'email')
				$status = OrderHelper::sendMail($orderId);
			if ($user_notification_type == 'sms')
				$status = OrderHelper::sendSMS($orderId, $order->user_id);
			break;
		}
	}
}