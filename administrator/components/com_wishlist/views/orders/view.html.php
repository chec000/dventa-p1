<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class WishlistViewOrders extends JViewLegacy
{
    /**
     *
     * @var type 
     */
    protected $items;

    /**
     *
     * @var type 
     */
    protected $state;

    /**
     *
     * @var type 
     */
    protected $pagination;
    
    /**
     * Accion Productos
     * 
     * @param type $tpl
     */
    function display($tpl = null)
    {

        $this->items = $this->get('Items');
        $this->state = $this->get('State');
        $this->pagination = $this->get('Pagination');
        $this->addToolbar();
        parent::display();
    }
    
    /**
     * 
     * @return type
     */
    protected function getSortFields()
    {
      return array(
        'a.created_at' => JText::_('COM_WISHLIST_MAIN_DATE'),
        'a.deleted_at' => JText::_('COM_WISHLIST_MAIN_DELETED'),
        'b.name' => JText::_('COM_WISHLIST_MAIN_USER'),
        'a.total' => JText::_('COM_WISHLIST_MAIN_TOTAL'),
        'a.id' => JText::_('COM_WISHLIST_MAIN_ID') 
    );
  }

  protected function addToolbar()
  {
    JToolbarHelper::title(JText::_('COM_WISHLIST_MAIN_TITLE'), '');

    $state = $this->get('State');
    $canDo = OrderHelper::getActions();

    $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/order';

    if (file_exists($formPath))
    {
        if ($canDo->get('core.create'))
        {
            JToolBarHelper::addNew('order.add', 'JTOOLBAR_NEW');
        }
    }

    if (isset($this->items[0]) && $canDo->get('core.delete'))
    {
        JToolbarHelper::custom(
            'orders.cancelar','cancel.png','','COM_WISHLIST_CANCEL_JTOOL',true);
    }

    if ($canDo->get('core.admin'))
    {
        JToolBarHelper::preferences('com_wishlist');
    }
}  
}