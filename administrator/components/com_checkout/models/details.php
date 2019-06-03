<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CheckoutModelDetails extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'details', $prefix = 'checkoutTable', 
        $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * 
     * @param type $data
     * @param type $loadData
     * @return boolean
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_checkout.details', 'details', 
            array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }
    
    /**
     * 
     * @return type
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $app  = JFactory::getApplication();
        $data = $app->getUserState('com_checkout.edit.details.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $data = $this->validateData($data);
        $this->preprocessData('com_checkout.details', $data);
        return $data;
    }

    /**
     * 
     * @return type
     */
    protected function validateData($data)
    {
        $order = JModelLegacy::getInstance('Orderm', 'CheckoutModel')->getOrder($data->id);
        $data->total = number_format($data->total);
        $data->user_id = $order->name;
        $data->email = $order->email;
        $data->created_by_id = $order->createdBy;
        if (is_null($order->deleted_at))
            $data->status = JText::_('COM_CHECKOUT_TAB_DETAILS_STATUS_TRUE');
        else
            $data->status = JText::_('COM_CHECKOUT_TAB_DETAILS_STATUS_FALSE');
        $data = $this->setDelivery($data);
        return $data;
    }

    public function setDelivery($data)
    {
        $delivery = null;
        $cedis = JModelLegacy::getInstance('Orderm', 'CheckoutModel')->getCedis($data->id);
        $address = JModelLegacy::getInstance('Orderm', 'CheckoutModel')->getAddress($data->id);
        if (!is_null($cedis))
            $delivery = $cedis;

        if (!is_null($address))
            $delivery = $address;

        if (!is_null($delivery)) {
            $data->street = $delivery->street;
            $data->extNum = $delivery->ext_number;
            $data->reference = $delivery->reference;
            $data->city = $delivery->city;
            $data->town = $delivery->town;
            $data->location = $delivery->location;
            $data->state = $delivery->estate;
            $data->zipCode = $delivery->zip_code;
        }
        return $data;
    }  
}