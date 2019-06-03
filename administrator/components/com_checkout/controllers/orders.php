<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CheckoutControllerOrders extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    public function getModel($name = 'orders', $prefix = 'checkoutModel', 
        $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
    
    public function cancelar()
    {
        $cid = JRequest::getVar('cid',  0, '');
        $model = $this->getModel('orders');
        foreach ($cid as $id){
            $model->cancelar($id);
        }
        $this->setRedirect(JRoute::_(
            'index.php?option=com_checkout&view=orders', false));
    }  
}