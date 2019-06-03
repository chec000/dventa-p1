<?php

/*
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 */
class CheckoutHelper
{
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function checkout(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'checkout');
        $view = $_this->getView('checkout','html'); 
        $_input->set('view', $vName);
        $view->delivery = $_input->getArray();
        $view->setModel( $_this->getModel('Config'));
        $view->setModel( $_this->getModel('Delivery'));
        $view->setModel( $_this->getModel('Transactions'));
        $view->setModel( $_this->getModel('Cart'));
        $view->setModel( $_this->getModel('Notification'));
        $view->setModel( $_this->getModel('Stock'));
        $view->setModel( $_this->getModel('Adcinema'));
    }  

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function survey(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'survey');
        $view = $_this->getView('survey','html');
        $_input->set('view', $vName);
        $view->setModel( $_this->getModel('Config'));
    }  

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function delivery(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'delivery');
        $view = $_this->getView('delivery','html');
        $_input->set('view', $vName);
        $view->survey = $_input->getArray();
        $view->setModel( $_this->getModel('Config'));
        $view->setModel( $_this->getModel('Delivery'));
        $view->setModel( $_this->getModel('Survey'));
        $view->setModel( $_this->getModel('Zipcode'));
        $view->params = self::setParamsDelivery();  
    }  

    /* 
     * @param type $_input
     * @param type $_this
     */
    public static function confirm(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'confirm');
        $view = $_this->getView('confirm','html');
        $_input->set('view', $vName);
        $view->delivery = $_input->getArray();
        $view->setModel( $_this->getModel('Cart'));
        $view->setModel( $_this->getModel('Config'));
        $view->setModel( $_this->getModel('Checkout'));
        $view->setModel( $_this->getModel('Delivery'));
    }  

    public static function autocompleteCode(&$_input,&$_this)
    {
        self::setAutocompleteData($_this, 'zip_code');
    }

    public static function autocompleteLocation(&$_input,&$_this)
    {
        self::setAutocompleteData($_this, 'location');
    }

    public static function autocompleteCity(&$_input,&$_this)
    {
        self::setAutocompleteData($_this, 'city');
    }

    public static function autocompleteTown(&$_input,&$_this)
    {
        self::setAutocompleteData($_this, 'town');
    }

    public static function autocompleteAction(&$_input,&$_this)
    {
        self::setAutocompleteData($_this, 'town');
    }

    private static function setAutocompleteData(&$_this, $field)
    {
        $app = JFactory::getApplication();
        $app->mimeType = 'application/json';

        $data = self::getAutocompleteData($_this, $field);

        $app->setHeader('Content-Type', $app->mimeType . '; charset=' . $app->charSet);
        $app->sendHeaders();
        echo json_encode(
            array('suggestions'=> $data
        )
        );
        $app->close();
    }

    private static function getAutocompleteData(&$_this, $field)
    {
        $search = is_null(JRequest::getVar('search'))?'':
        JRequest::getVar('search');

        $params['zip_code'] = JRequest::getVar('zc');
        $params['location'] = JRequest::getVar('location');
        $params['city'] = JRequest::getVar('city');

        $return = array();
        $zipCodes = $_this->getModel('Zipcode');
        $return = $zipCodes->getItems($search, $field, $params);

        $codes = array();
        foreach ($return as $code) {
            $code = array(
                'data'=>$code,
                'value'=>$code->$field
            );
            array_push($codes, $code);
        }

        if (empty($codes))
        {
            $codes = array();
        }
        return $codes;
    }

    /**
     * 
     * @return type
     */
    private static function setParamsDelivery()
    {
        return array(
            'cedis' => is_null(JRequest::getVar('cedis'))?'':
            JRequest::getVar('cedis')
        );        
    }  

    public static function getCheckoutState()
    {
        $statusxUser = self::getCheckoutStatexUser();
        if ($statusxUser) {
            return true;
        }

        $status = self::getCheckoutStatexRol();
        if (is_null($status)) {
            $configs = JModelLegacy::getInstance('Config', 'CheckoutModel');
            $start = is_null($configs->getConfig('checkout.date.start'))?null:$configs->getConfig('checkout.date.start')->value;
            $end = is_null($configs->getConfig('checkout.date.end'))?null:$configs->getConfig('checkout.date.end')->value;
            $status = self::checkInRange($start, $end, self::getTimestamp());
        }
        return $status;
    }

    public static function getCheckoutStatexUser()
    {
        $checkoutxUser = self::getComponentParams('com_checkout_status','users_list');
        if (is_null($checkoutxUser)) {
            return false;
        }

        return in_array(JFactory::getUser()->id, $checkoutxUser);
    }

    private static function getCheckoutStatexRol()
    {
        $roles = self::getRoles();
        $checkoutStatusModel = JModelLegacy::getInstance('Checkout_State', 'CheckoutModel');
        $checkoutStatus = $checkoutStatusModel->getCheckoutStatus($roles['string']);
        $checkoutStatus = isset($checkoutStatus[0])?$checkoutStatus[0]:null;
        
        if (!is_null($checkoutStatus)) {
            $status = self::checkInRange($checkoutStatus->start_date, $checkoutStatus->end_date, self::getTimestamp());
            return $status;
        }
        return $checkoutStatus;
    }

    public static function getRoles()
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

    public static function getConfigParams($key)
    {
        $configs = JModelLegacy::getInstance('Config', 'CheckoutModel');
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

    public static function sendMailOrder($params)
    {
        $status = false;
        $body = self::buildEmailTemplate($params);
        if ($body == '') {
            $body = '<div>Este es su numero de canje: ' . $params['id']
            . '</div>';
        }
        $subject = JText::_('COM_CHECKOUT_MAIL_SUBJECT');
        if ($params['email'] != '') {
            $status = self::sendMail($body, $subject, trim($params['email']));
        }
        return $status;
    }

    public static function buildEmailTemplate($params)
    {
        $template = '';
        $notification = JModelLegacy::getInstance('Notification','CheckoutModel');
        $html = is_null($notification->getTemplae('com_checkout'))
        ?null:$notification->getTemplae('com_checkout')->value;

        ob_start();
        $template = eval('$data=$params ?>' . $html);
        $template .= ob_get_clean();

        return $template;
    }

    public static function setEmailParams($id)
    {
        $config = self::getComponentParams('com_checkout', 'profile_info');
        $orders = JModelLegacy::getInstance('Checkout', 'CheckoutModel');
        $order = $orders->getOrder($id);

        if ($config == '1') {
            $params['profile'] = self::completeUserProfileFromInfo($order->user_id, $id);
        }
        else{
            $params['profile'] = self::completeUserProfileFromProfile($order->user_id);
        }

        $params['date'] = $order->created_at;
        $params['email'] = JFactory::getUser($order->user_id)->email;
        $params['id'] = $id;
        $params['user'] = JFactory::getUser($order->user_id);
        $params['items'] = $orders->getProducts($id);
        $params['total'] = $order->total;
        $cedis = $orders->getCedis($id);
        $address = $orders->getAddress($id);
        $delivery = null;
        if (!is_null($cedis))
            $delivery = $cedis;

        if (!is_null($address))
            $delivery = $address;

        if (is_null($delivery)) {
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
        }
        $params['details'] = $delivery;
        $params['details']->names_cedis = isset($cedis->names_cedis)?$cedis->names_cedis:'N/A';
        return $params;
    }

    public static function completeUserProfileFromProfile($user)
    {
        $profile = new stdClass();
        $profile->last_name1 = self::getUserProfile('profile.last_name1', $user);
        $profile->last_name2 = self::getUserProfile('profile.last_name2', $user);
        $profile->last_name = $profile->last_name1 . ' ' . $profile->last_name2;
        $profile->city = self::getUserProfile('profile.city', $user);
        $profile->estate = self::getUserProfile('profile.estate', $user);
        $profile->num_cel = self::getUserProfile('profile.num_cel', $user);
        $profile->num_tel = self::getUserProfile('profile.num_tel', $user);
        return $profile;
    }

    public static function completeUserProfileFromInfo($user, $orderId)
    {
        $orders = JModelLegacy::getInstance('Checkout', 'CheckoutModel');
        $cedis = $orders->getCedis($orderId);
        $info = self::getUserInfo($user);

        $profile = new stdClass();
        $profile->last_name = isset($info->lastname)?$info->lastname:'';
        $profile->city = isset($cedis->city)?$cedis->city:'N/A';
        $profile->estate = isset($cedis->estate)?$cedis->estate:'N/A';
        $profile->num_cel = isset($info->cellphone)?$info->cellphone:'';
        $profile->num_tel = isset($info->telephone)?$info->telephone:'';
        return $profile;
    }

    public static function getUserInfo($user)
    {
        $userModel = JModelLegacy::getInstance('User', 'CheckoutModel');
        return $userModel->getProfileInfo($user);
    }

    public static function getUserProfile($key, $user)
    {
        $userModel = JModelLegacy::getInstance('User', 'CheckoutModel');
        $user_profile = $userModel->getProfileByKey($user, $key);
        return isset($user_profile->profile_value)?trim($user_profile->profile_value, '"'):'';
    }
}