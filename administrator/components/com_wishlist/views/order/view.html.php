<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_WISHLIST
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class WishlistViewOrder extends JViewLegacy
{
    /**
     *
     * @var type 
     */
    protected $item;

    /**
     *
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
        JToolbarHelper::title(JText::_('COM_WISHLIST_MAIN_TITLE'), ''); 
        $canDo = OrderHelper::getActions();
        if ($canDo->get('core.create'))
        {
            JToolbarHelper::save('order.guardar');
        }
        JToolbarHelper::cancel('order.cancel');
    }
}