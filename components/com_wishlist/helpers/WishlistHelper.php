<?php

/*
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 */
class WishlistHelper
{
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function wishlist(&$_input,&$_this)
    {
        $view = $_this->getView('wishlist','html');
        $view->display();
    }  

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function checkout(&$_input,&$_this)
    {
        $view = $_this->getView('checkout','html');
        $view->display();
    }  

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function survey(&$_input,&$_this)
    {
        $view = $_this->getView('survey','html');
        $view->checkoutProducts = JRequest::getVar('products');
        $view->display();
    }   

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function confirm(&$_input,&$_this)
    {
        $view = $_this->getView('confirm','html');
        $view->survey = $_input->getArray();
        $view->checkoutProducts = JRequest::getVar('products');
        $view->display();
    }

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function addList(&$_input,&$_this)
    {
        $view = $_this->getView('wishlist','html');      
        $view->params = self::setCreateListParams();
        $view->display();
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function deleteList(&$_input,&$_this)
    {
        $view = $_this->getView('wishlist','html');
        $view->params = self::setDeleteParams();
        $view->display();
    }

    public static function setCreateListParams()
    {
        return array(
            'operation' => 'create',
            'product' => JRequest::getVar('product'),
            'quantity' => 1
        ); 
    }

    public static function setDeleteParams()
    {
        return array(
            'operation' => 'delete',
            'products' => JRequest::getVar('products')
        );
    }

    public static function getCheckoutState()
    {
        $status = self::getCheckoutStatexRol();
        if (is_null($status)) {
            $configs = JModelLegacy::getInstance('Config', 'WishlistModel');
            $start = is_null($configs->getConfig('checkout.date.start'))?null:$configs->getConfig('checkout.date.start')->value;
            $end = is_null($configs->getConfig('checkout.date.end'))?null:$configs->getConfig('checkout.date.end')->value;
            $status = self::checkInRange($start, $end, self::getTimestamp());
        }
        return $status;
    }

    private static function getCheckoutStatexRol()
    {
        $roles = self::getRoles();
        $checkoutStatusModel = JModelLegacy::getInstance('Checkout_State', 'WishlistModel');
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

    public static function getComponentParams($component, $key)
    {
        $params = JComponentHelper::getParams($component);
        return  $params[$key];
    }  

    public static function setEmailParams($id)
    {
        $orders = JModelLegacy::getInstance('Wishlist', 'WishlistModel');
        $order = $orders->getOrder($id);
        $params['email'] = JFactory::getUser($order->user_id)->email;
        $params['id'] = $id;
        $params['items'] = $orders->getProducts($id);
        $params['total'] = $order->total;

        $delivery = new stdClass();
        $delivery->street = '';
        $delivery->ext_number = '';
        $delivery->int_number = '';
        $delivery->reference = '';
        $delivery->city = '';
        $delivery->town = '';
        $delivery->location = '';
        $delivery->estate = '';
        $delivery->zip_code = '';
        $params['details'] = $delivery;
        return $params;
    }

    public static function sendMailOrder($params)
    {
        $status = false;
        $body = self::buildEmailTemplate($params);
        if ($body == '') {
            $body = '<div>Este es su numero de canje: ' . $params['id']
            . '</div>';
        }
        $subject = JText::_('COM_WISHLIST_MAIL_SUBJECT');
        if ($params['email'] != '') {
            $status = self::sendMail($body, $subject, trim($params['email']));
        }
        return $status;
    } 

    public static function buildEmailTemplate($params)
    {
        $template = '';
        $notification = JModelLegacy::getInstance('Notification','WishlistModel');
        $html = is_null($notification->getTemplae('com_checkout'))
        ?null:$notification->getTemplae('com_checkout')->value;

        ob_start();
        $template = eval('$data=$params ?>' . $html);
        $template .= ob_get_clean();

        return $template;
    }
    
    public static function getConfigParams($key)
    {
        $configs = JModelLegacy::getInstance('Config', 'WishlistModel');
        return is_null($configs->getConfig($key))?'none':$configs->getConfig($key)->value;
    }

    public static function sendMail($body, $subject, $mail)
    {
        $send = false;
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( 
            $config->get('mailfrom'),
            $config->get('fromname') 
        );

        $mailer->setSender($sender);
        $mailer->addRecipient($mail);
        $mailer->setSubject($subject);

        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        $send = $mailer->Send();
        return $send;
    }
}