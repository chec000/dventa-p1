<?php

/**
 * @version    1.0.0
 * @package    COM_CHECKOUT_STATUS
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */
// No direct access
defined('_JEXEC') or die;

/**
 *
 *
 * @since  1.6
 */
class Checkout_StatusViewCheckout_Status extends JViewLegacy
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->initConfig();
		$this->checkoutOperations();
		$this->changeChekoutPeriod();
		$this->checkoutstate = $this->getCheckoutState();
		$this->startDate = $this->getFormatedData('checkout.date.start');
		$this->endDate = $this->getFormatedData('checkout.date.end');
		$this->startLimit = $this->getStartLimit();
		$this->endLimit = $this->getEndLimitPlus();
		Checkout_StatusHelper::addSubmenu();
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	public function createLog($action, $type)
	{
		$params = array(
			'action' => $action,
			'type' => $type,
			'applied_at' => date('Y-m-d H:i:s', Checkout_StatusHelper::getTimestamp())
		);
		$log = JModelLegacy::getInstance('Clogm', 'Checkout_StatusModel');
		$log->createLog($params);
	}

	public function sendMail($params)
	{
		$params['date'] = date('Y-m-d H:i:s', Checkout_StatusHelper::getTimestamp());
		$emails = Checkout_StatusHelper::getComponentParams('com_checkout_status','checkout_emails');
		$emails = explode(',',$emails);
		$subject = JText::_('COM_CHECKOUT_STATUS_MAIL_SUBJECT');
		$body   = '<h2>'.JText::_('COM_CHECKOUT_STATUS_MAIL_BODY').'</h2>'
		. '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_TYPE') . 'General' . '</div>'
		. '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_DATE') . $params['date'] . '</div>'
		. '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_STARTDATE') . $params['startDate'] . '</div>'
		. '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_ENDDATE') . $params['endDate'] . '</div>';
		foreach ($emails as $email) {
			if ($email != '') {
				Checkout_StatusHelper::sendMail($body, $subject, trim($email));
			}
		}
	}

	public function initConfig()
	{
		$startDatekey = 'checkout.date.start';
		$endDatekey = 'checkout.date.end';
		$configs = $this->getModel('Config');

		$startDate = is_null($configs->getConfig($startDatekey))?
		null:$configs->getConfig($startDatekey)->value;

		$endDate = is_null($configs->getConfig($endDatekey))?
		null:$configs->getConfig($endDatekey)->value;

		if (is_null($startDate))
			$this->insertConfig($startDatekey, 0, 1);

		if (is_null($endDate))
			$this->insertConfig($endDatekey, 0, 1);
	}

	public function insertConfig($key, $value, $visibility)
	{
		$configs = $this->getModel('Config');
		$configs->insertConfig($key, $value, $visibility);
	}

	public function getPermissions()
	{
		$canDo = Checkout_StatusHelper::getActions();
		return $canDo;
	}

	protected function addToolbar()
	{
		$state = $this->get('State');

		$canDo = Checkout_StatusHelper::getActions();

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_checkout_status');
		}

		JHtmlSidebar::setAction('index.php?option=com_checkout_status');
	}  
	
	public function checkoutOperations()
	{
		$canDo = $this->getPermissions();
		if ($canDo->get('core.edit'))
		{
			$action = isset($this->action)?$this->action:null;
			$now = $this->getStartLimit();
			switch ($action) {
				case 'open':
				$this->changeDate('checkout.date.start', $now);
				$this->changeDate('checkout.date.end', $this->getEndLimit());
				$this->createLog('open','General');
				$params = array(
					'startDate' => $now,
					'endDate' => $this->getEndLimit()
				);
				$this->sendMail($params);
				break;
				case 'close':
				$this->changeDate('checkout.date.start', $now);
				$this->changeDate('checkout.date.end', $now);
				$this->createLog('close','General');
				$this->empyCart();
				break;
			}
		}
	}

	public function empyCart()
	{
		$cart = JModelLegacy::getInstance('Cart', 'Checkout_StatusModel');
		$cart->emptyCart();
	}

	public function changeChekoutPeriod()
	{
		$canDo = $this->getPermissions();
		if ($canDo->get('core.edit'))
		{
			$data = $this->data;
			if ($this->validateDateTime($data, 'startDate') && $this->validateDateTime($data, 'endDate')) {
				$this->changeDate('checkout.date.start', $data['startDate']);
				$this->changeDate('checkout.date.end', $data['endDate']);
				$this->createLog('change','General');
				$status = Checkout_StatusHelper::checkInRange(
					strtotime($data['startDate']), strtotime($data['endDate']), 
					Checkout_StatusHelper::getTimestamp());
				if ($status) {
					$params = array(
						'startDate' => $data['startDate'],
						'endDate' => $data['endDate']
					);
					$this->sendMail($params);
				}
			}
		}
	}

	public function validateDateTime($data, $key)
	{
		if (isset($data[$key])) {
			if ($data[$key] != '')
				return true;
			else
				return false;
		}
	}

	public function changeDate($key, $value)
	{
		$configs = $this->getModel('Config');
		$configs->updateConfig($key, strtotime($value));
	}

	public function getFormatedData($key)
	{
		$configs = $this->getModel('Config');
		$timestamp = is_null($configs->getConfig($key))?
		null:$configs->getConfig($key)->value;
		$datevalue = Checkout_StatusHelper::getFormatedDate($timestamp);
		return $datevalue;
	}

	public function getDate($key)
	{
		$configs = $this->getModel('Config');
		$timestamp = is_null($configs->getConfig($key))?
		null:$configs->getConfig($key)->value;
		return $timestamp;
	}

	public function getCheckoutState()
	{
		$start = $this->getDate('checkout.date.start');
		$end = $this->getDate('checkout.date.end');
		$status = Checkout_StatusHelper::checkInRange($start, $end, Checkout_StatusHelper::getTimestamp());
		return $status;
	}

	public function getStartLimit(){
		$now = Checkout_StatusHelper::getTimestamp();
		$datevalue = Checkout_StatusHelper::getFormatedDate($now);
		return $datevalue;
	}

	public function getEndLimit(){
		$now = Checkout_StatusHelper::getTimestamp();
		$now = Checkout_StatusHelper::getFormatedDate($now);
		$timestamp = strtotime('+1 year',strtotime($now));
		$datevalue = Checkout_StatusHelper::getFormatedDate($timestamp);
		return $datevalue;
	}

	public function getEndLimitPlus(){
		$now = Checkout_StatusHelper::getTimestamp();
		$now = Checkout_StatusHelper::getFormatedDate($now);
		$timestamp = strtotime('+1 day',strtotime($now));
		$datevalue = Checkout_StatusHelper::getFormatedDate($timestamp);
		return $datevalue;
	}
}
