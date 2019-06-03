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
class Checkout_StatusViewCxrols extends JViewLegacy
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
		$this->items = $this->validateItems();
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		Checkout_StatusHelper::addSubmenu();
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	public function validateItems()
	{
		$items = $this->get('Items');
		foreach ($items as $item) {
			$status = Checkout_StatusHelper::checkInRange($item->start_date, $item->end_date, 
				Checkout_StatusHelper::getTimestamp());
			$item->checkoutStatus = $status;
		}
		return $items;
	}

	public function getFormatedDate($timestamp)
	{
		return Checkout_StatusHelper::getFormatedDate($timestamp);
	}

	/**
     * 
     * @return type
     */
	protected function getSortFields()
	{
		return array(
			'c.id' => JText::_('COM_CHECKOUT_STATUS_FIELD_ID'),
			'checkoutStatus' => JText::_('COM_CHECKOUT_STATUS_FIELD_STATUS'),
			'c.start_date' => JText::_('COM_CHECKOUT_STATUS_FIELD_STARTDATE'),
			'c.end_date' => JText::_('COM_CHECKOUT_STATUS_FIELD_ENDDATE'),
			'rolid' => JText::_('COM_CHECKOUT_STATUS_FIELD_ROLID'),
			'rol' => JText::_('COM_CHECKOUT_STATUS_FIELD_ROL'),
			'c.created_at' => JText::_('COM_CHECKOUT_STATUS_FIELD_CREATEDAT'),
			'c.updated_at' => JText::_('COM_CHECKOUT_STATUS_FIELD_UPDATEDAT')
		);
	} 

	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = Checkout_StatusHelper::getActions();

		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/cxrol';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('cxrol.add', 'JTOOLBAR_NEW');
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('cxrol.edit', 'JTOOLBAR_EDIT');
			}

			if ($canDo->get('core.delete'))
			{
				if (isset($this->items[0]))
				{
					JToolBarHelper::deleteList('', 'cxrols.delete', 'JTOOLBAR_DELETE');
				}
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_checkout_status');
		}

		JHtmlSidebar::setAction('index.php?option=com_checkout_status');
	}  
}