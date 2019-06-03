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
class Checkout_StatusViewClogs extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

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
		$this->items = $this->validateItems();
		$this->pagination = $this->get('Pagination');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		Checkout_StatusHelper::addSubmenu();
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	public function validateItems()
	{
		$items = $this->get('Items');
		foreach ($items as $item) {
			$item->profile = $this->getRoles($item->user_id)['string'];
			$item->action = $this->getActionLable($item->action);
		}
		return $items;
	}

	public function getActionLable($action)
	{
		$actionLbl = '';
		switch ($action) {
			case 'open':
			$actionLbl =JText::_('COM_CHECKOUT_STATUS_CLOGS_ACTION_OPEN');
			break;
			case 'close':
			$actionLbl =JText::_('COM_CHECKOUT_STATUS_CLOGS_ACTION_CLOSE');
			break;
			case 'change':
			$actionLbl =JText::_('COM_CHECKOUT_STATUS_CLOGS_ACTION_CHANGE');
			break;
		}
		return $actionLbl;
	}

	public function getRoles($user_id){
		$user = JFactory::getUser($user_id);
		$rolesString = "";
		foreach ($user->groups as $group) {
			$rolesString .= $this->getRolesName($group) . ',';
		}
		$rolesString = substr($rolesString, 0, -1);
		$roles['string'] = $rolesString;
		$roles['array'] = $user->groups;
		return $roles;
	}

	public function getRolesName($id)
	{
		$db     = JFactory::getDBO();
		$query  = $db->getQuery(true);
		$query->select('id, title');
		$query->from('#__usergroups');
		$query->where('id = ' . $id);
		$db->setQuery($query);
		$rows   = $db->loadObject();
		return isset($rows->title)?$rows->title:null;
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$canDo = $canDo = Checkout_StatusHelper::getActions();
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_checkout_status');
		}
		JHtmlSidebar::setAction('index.php?option=com_checkout_status&view=clogs');
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.id' => JText::_('COM_CHECKOUT_STATUS_CLOGS_ID'),
			'u.username' => JText::_('COM_CHECKOUT_STATUS_CLOGS_USER'),
			'profile' => JText::_('COM_CHECKOUT_STATUS_CLOGS_PROFILE'),
			'a.applied_at' => JText::_('COM_CHECKOUT_STATUS_CLOGS_APPLIED'),
			'a.action' => JText::_('COM_CHECKOUT_STATUS_CLOGS_ACTION'),
			'a.type' => JText::_('COM_CHECKOUT_STATUS_CLOGS_TYPE'),
			'a.created_at' => JText::_('COM_CHECKOUT_STATUS_CLOGS_CREATED'),
		);
	}

    /**
     * Check if state is set
     *
     * @param   mixed  $state  State
     *
     * @return bool
     */
    public function getState($state)
    {
    	return isset($this->state->{$state}) ? $this->state->{$state} : false;
    }
}
