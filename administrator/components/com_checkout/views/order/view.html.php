<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class CheckoutViewOrder extends JViewLegacy
{
    /**
     *
     * @var type 
     */
    protected $item;

    /**
     *        $this->isSync = CatalogHelper::setSync();
     * @var type 
     */
    protected $form;  
    
    /**
     * Accion Productos
     * 
     * @param type $tpl
     */
    public function display($tpl = null)
    {     
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');
        $this->addTools();
        parent::display($tpl);
    } 
    
    /**
     * 
     */
    public function addTools()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolbarHelper::title(JText::_('COM_CHECKOUT_MAIN_TITLE'), ''); 
        JToolbarHelper::save('order.guardar');
        JToolbarHelper::cancel('order.cancel');
    }
}