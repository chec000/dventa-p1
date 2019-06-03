<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class CheckoutViewDetails extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->items = $this->getOrderProducts();
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function getOrderProducts()
	{
		$orderId = JRequest::getVar('id',  0, '');
		$orders = JModelLegacy::getInstance('Orderm', 'CheckoutModel');
		$products = $orders->getProducts($orderId);
		if (empty($products)) {
			$this->reDirectPage('index.php?option=com_checkout');
		}
		return $products;
	}

	protected function getFormValue($field)
	{
		$value = $this->form->getValue($field);
		return $value;

	}

	protected function reDirectPage($url)
	{
		$app = JFactory::getApplication();
		$route = JRoute::_($url, false);
		$app->redirect($route);
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$canDo = OrderHelper::getActions();
		JToolbarHelper::title(JText::_('COM_CHECKOUT_MAIN_TITLE'), '');
		JToolbarHelper::custom('details.confirmation','mail.png','',JText::_('COM_CHECKOUT_DETAILS_CONFIRMATION'),false);
		if ($canDo->get('core.delete'))
		{
			if ($this->getFormValue('id') > 0)
			{
				JToolBarHelper::custom('details.cancelar', 'delete.png','', 'COM_CHECKOUT_CANCEL_JTOOL', false);
			}
		}
		if (!$canDo->get('core.edit'))
		{
			$this->reDirectPage('index.php?option=com_checkout');
		}
		JToolbarHelper::custom('details.back','back.png','',JText::_('COM_CHECKOUT_DETAILS_BACK'),false);
	}
}