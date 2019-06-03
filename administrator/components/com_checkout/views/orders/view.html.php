<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class CheckoutViewOrders extends JViewLegacy
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
        $this->ordersTotal = $this->getOrdersCount($this->items);
        $this->completedOrders = $this->getOrdersCompletedCount($this->items);
        $this->cancelledOrders = $this->getOrdersCancelledCount($this->items);
        parent::display();
    }

    protected function getOrdersCount($orders)
    {
        return count($orders);
    }

    protected function getOrdersCompletedCount($orders)
    {
        $completed = 0;
        foreach ($orders as $order) {
            if (is_null($order->deleted_at)) {
                $completed += 1;
            }
        }
        return $completed;
    }

    protected function getOrdersCancelledCount($orders)
    {
        $cancelled = 0;
        foreach ($orders as $order) {
            if (!is_null($order->deleted_at)) {
                $cancelled += 1;
            }
        }
        return $cancelled;
    }
    
    /**
     * 
     * @return type
     */
    protected function getSortFields()
    {
        return array(
          'a.created_at' => JText::_('COM_CHECKOUT_MAIN_DATE'),
          'a.deleted_at' => JText::_('COM_CHECKOUT_MAIN_DELETED'),
          'b.name' => JText::_('COM_CHECKOUT_MAIN_USER'),
          'a.total' => JText::_('COM_CHECKOUT_MAIN_TOTAL'),
          'a.id' => JText::_('COM_CHECKOUT_MAIN_ID') 
      );
    }  

    protected function addToolbar()
    {
        JToolbarHelper::title(JText::_('COM_CHECKOUT_MAIN_TITLE'), '');

        $canDo = OrderHelper::getActions();

        if ($canDo->get('core.create'))
        {
            JToolBarHelper::addNew('order.add', 'JTOOLBAR_NEW');
        }
        if ($canDo->get('core.delete'))
        {
            if (isset($this->items[0]))
            {
                JToolBarHelper::deleteList('', 'orders.cancelar', 'COM_CHECKOUT_CANCEL_JTOOL');
            }
        }

        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_checkout');
        }

        JHtmlSidebar::setAction('index.php?option=com_checkout&view=orders');
    }      
}