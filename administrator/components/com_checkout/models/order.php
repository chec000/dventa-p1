<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CheckoutModelOrder extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'order', $prefix = 'checkoutTable', 
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
        $form = $this->loadForm('com_checkout.order', 'order', 
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
        $data = $app->getUserState('com_checkout.edit.order.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $this->preprocessData('com_checkout.order', $data);
        return $data;
    }

    public function guardar($data)
    {
        $user_id = isset($data['user_id'])?$data['user_id']:0;
        $product_id = isset($data['product_id'])?$data['product_id']:0;
        $amount = isset($data['amount'])?$data['amount']:0;

        $params = array(
            'user' => $user_id,
            'product' => $product_id,
            'amount' => $amount,
            'revision' => 1,
            'type' => 'order',
            'address' => OrderHelper::getUserAddress($user_id)
        );

        $orders = JModelLegacy::getInstance('Orderm', 'CheckoutModel');
        $result = $orders->createOrder($params);
        if ($result == 0) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_CHECKOUT_MAIN_ORDER_ERROR'), 'error');
        }
        else{
           JFactory::getApplication()->enqueueMessage(JText::_('COM_CHECKOUT_MAIN_ORDER_SUCCESS'), 'message');
       }
       return $result;
   }
}