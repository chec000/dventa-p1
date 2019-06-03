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
class Checkout_StatusViewCxrol extends JViewLegacy
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
        $this->setCurrentDate();
        Checkout_StatusHelper::addSubmenu();
        $this->addTools();
        parent::display($tpl);
    } 

    public function setCurrentDate()
    {
        $this->changeDate('start_date');
        $this->changeDate('end_date');
    }

    public function changeDate($field)
    {
        $fieldValue = $this->form->getValue($field, null);
        if ($fieldValue == '1970-01-01') {
            $this->form->setValue($field, null, $this->getCurrentDate());
        }
    }

    public function getCurrentDate()
    {
        $now = Checkout_StatusHelper::getTimestamp();
        return Checkout_StatusHelper::getFormatedDate($now);
    }
    
    /**
     * 
     */
    public function addTools()
    {
    	JFactory::getApplication()->input->set('hidemainmenu', true);

    	$canDo = Checkout_StatusHelper::getActions();
    	if ($canDo->get('core.create') || ($canDo->get('core.edit')))
    	{
    		JToolbarHelper::save('cxrol.guardar');
    	}      
    	JToolbarHelper::cancel('cxrol.cancel');
    }  
}