<?php

/*
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 */
class CartHelper
{
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function cart(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'cart');
        $_input->set('view', $vName);
        $view = $_this->getView('cart','html'); 
        $view->setModel( $_this->getModel('Transactions'));
    }  

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function delete(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'cart');
        $_input->set('view', $vName);
        $view = $_this->getView('cart','html');
        $view->params = self::setDeleteParams();
        $view = $_this->getView('cart','html'); 
        $view->setModel( $_this->getModel('Transactions'));
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function update(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'cart');
        $_input->set('view', $vName);
        $view = $_this->getView('cart','html');      
        $view->params = self::setUpdateParams();
        $view = $_this->getView('cart','html'); 
        $view->setModel( $_this->getModel('Transactions'));
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function emptyCart(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'cart');
        $_input->set('view', $vName);
        $view = $_this->getView('cart','html');      
        $view->params = self::setEmptyCartParams();
        $view = $_this->getView('cart','html'); 
        $view->setModel( $_this->getModel('Transactions'));
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function create(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'cart');
        $_input->set('view', $vName);
        $view = $_this->getView('cart','html');      
        $view->params = self::setCreateCartParams();
        $view = $_this->getView('cart','html'); 
        $view->setModel( $_this->getModel('Transactions'));
    }

    public static function setDeleteParams()
    {
        return array(
            'operation' => 'delete',
            'id' => JRequest::getVar('id')
        );
    }

    public static function setUpdateParams()
    {
        return array(
            'operation' => 'update',
            'id' => JRequest::getVar('id'),
            'quantity' => JRequest::getVar('quantity')
        ); 
    }

    public static function setEmptyCartParams()
    {
        return array(
            'operation' => 'empty'
        ); 
    }

    public static function setCreateCartParams()
    {
        return array(
            'operation' => 'create',
            'product' => JRequest::getVar('product'),
            'quantity' => JRequest::getVar('quantity')
        ); 
    }

    public static function getCheckoutState()
    {
        $status = self::getCheckoutStatexRol();
        if (is_null($status)) {
            $configs = JModelLegacy::getInstance('Cart', 'CartModel');
            $start = is_null($configs->getConfig('checkout.date.start'))?null:$configs->getConfig('checkout.date.start')->value;
            $end = is_null($configs->getConfig('checkout.date.end'))?null:$configs->getConfig('checkout.date.end')->value;
            $status = self::checkInRange($start, $end, self::getTimestamp());
        }
        return $status;
    }

    private static function getCheckoutStatexRol()
    {
        $roles = self::getRoles();
        $checkoutStatusModel = JModelLegacy::getInstance('Checkout_State', 'CartModel');
        $checkoutStatus = $checkoutStatusModel->getCheckoutStatus($roles['string']);
        $checkoutStatus = isset($checkoutStatus[0])?$checkoutStatus[0]:null;
        
        if (!is_null($checkoutStatus)) {
            $status = self::checkInRange($checkoutStatus->start_date, $checkoutStatus->end_date, self::getTimestamp());
            return $status;
        }
        return $checkoutStatus;
    }

    private static function getRoles()
    {
        $user = JFactory::getUser();
        $rolesString = "";
        foreach ($user->groups as $group) {
            $rolesString .= $group . ',';
        }
        $rolesString = substr($rolesString, 0, -1);
        $roles['string'] = $rolesString;
        $roles['array'] = $user->groups;
        return $roles;
    }

    public static function checkInRange($start_date, $end_date, $date)
    {
        return (($date >= $start_date) && ($date <= $end_date));
    }

    public static function getTimestamp(){
        $date = new DateTime('America/Mexico_City');
        $now = (int) $date->getTimestamp();
        return $now;
    }
}
