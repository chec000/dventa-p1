<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistModelOrder extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'order', $prefix = 'wishlistTable', 
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
        $form = $this->loadForm('com_wishlist.order', 'order', 
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
        $data = $app->getUserState('com_wishlist.edit.order.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $this->preprocessData('com_wishlist.order', $data);
        return $data;
    }

    public function guardar($data)
    {
        $user_id = isset($data['user_id'])?$data['user_id']:0;
        $product_id = isset($data['product_id'])?$data['product_id']:0;
        $amount = isset($data['amount'])?$data['amount']:0;
        $revision = 1;

        $params = array(
            'user' => $user_id,
            'product' => $product_id,
            'amount' => $amount,
            'revision' => $revision,
            'type' => 'order'
        );

        $orders = JModelLegacy::getInstance('Orderm', 'WishlistModel');
        $result = $orders->createOrder($params);
        return $result;
    }
}