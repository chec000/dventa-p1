<?php

/**
 * @version    1.0.0
 * @package    com_catalog
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */
// No direct access
defined('_JEXEC') or die;

/**
 * View to edit
 *
 * @since  1.6
 */
class CatalogViewCproduct extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;

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
		$this->state = $this->get('State');
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_CATALOG'), 'configs.png');
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$canDo = CatalogHelper::getActions();

		if (($canDo->get('core.edit') || ($canDo->get('core.create'))))
		{
			JToolBarHelper::save('cproduct.save', 'JTOOLBAR_SAVE');
		}

		if ($canDo->get('core.create'))
		{
			JToolBarHelper::custom('cproduct.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('cproduct.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('cproduct.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
