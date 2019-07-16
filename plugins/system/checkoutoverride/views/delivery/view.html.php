<?php

defined('_JEXEC') or die('Restricted access');

class CheckoutViewDelivery extends JViewLegacy {

    function display($tpl = null) {


        JText::script('COM_CHECKOUT_FIELD_ERROR_STREET');

        $this->saveSurvey($this->survey);
        JHtml::_('jquery.framework');
        JHtml::_('script', 'jui/jquery.autocomplete.min.js', array('version' => 'auto', 'relative' => true));
        $this->load_assets();

        $userId = JFactory::getUser()->id;
        $deliveryModel = $this->getModel('Delivery');
        if ($userId > 0) {
            $configs = $this->getModel('Config');
            $this->delivery = is_null($configs->getConfig('checkout.delivery.mode')) ?
                    null : $configs->getConfig('checkout.delivery.mode')->value;
            $this->cedis_list = $deliveryModel->getCedisList();
            $this->cedis = $this->getUserCedis($this->params['cedis'], $deliveryModel);
            $this->address = $this->getUserAddress();
            $this->states = $this->getStates();
       
            
        } else {
            $this->userId = $userId;
        }
        $this->productTypes = $deliveryModel->getProductTypes();
        $edit = CheckoutHelper::getComponentParams('com_checkout', 'delivery_edit');
        
            $edit="1";
        $edit = (is_null($edit) || $edit == "1") ? true : false;

        $this->editDelivery = $edit;
        $this->addTemplatePath(__DIR__ . '/tmpl/');
        parent::display();
    }

    public function getUserAddress() {
        $user_info=$this->getUserInfo(JFactory::getUser()->id);
        
        $address = new stdClass();

            if ($user_info!=null) {
    # code...
        $address->street = $user_info->street;
        $address->ext_number =$user_info->ext_number; 
        $address->int_number = $user_info->int_number;
        $address->reference = $user_info->reference;
        $address->zip_code = $user_info->zip_code;
        $address->neighborhood = "";
        $address->location = $user_info->location;
        $address->city = $user_info->city;        
        $address->state = $user_info->state;
        $address->phone = $user_info->phone;
        $address->cellphone = $user_info->cellphone;
        
            }   

        return $address;
    }

    public function getUserCedis($params, $deliveryModel) {
        $cedis = $deliveryModel->getCedis($params);
        if ($cedis->id == '') {
            $cedis = $deliveryModel->getCedis($this->getUserCedisId($deliveryModel));
            if ($cedis->id == '') {
                $cedis->estate = '';
            }
        }
        return $cedis;
    }

    public function getUserProfile($key) {
        

            $this->getUserInfo(JFactory::getUser()->id);

        return isset($user_profile->profile_value) ? trim($user_profile->profile_value, '"') : '';
    }

    private function getUserInfo($userId){
                $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        $query
                ->select('u.*')
                ->from($db->quoteName('#__core_user_info','u'))
                ->where($db->quoteName('u.user_id') . ' = ' . $db->quote($userId))
                ->setLimit('1');
        $db->setQuery($query);
    
        $user_info = $db->loadObject();
    
        return $user_info;
    }


    public function getUserCedisId($deliveryModel) {

        return $deliveryModel->getCedisMap(JFactory::getUser()->id);
    }

    public function getStates() {
        $zipCodes = $this->getModel('Zipcode');
        $return = $zipCodes->getStates();
        return $return;
    }

    public function saveSurvey($data) {
        $survey = array();
        $size = sizeof($data);
        for ($i = 1; $i <= $size; $i++) {
            $index = 'q' . $i;
            if (array_key_exists($index, $data)) {
                $survey['q' . $i] = isset($data['q' . $i]) ? $data['q' . $i] : null;
            }
        }
        $surveyModel = $this->getModel('Survey');
        $surveyModel->saveSurvey($survey);
    }

    public function load_assets() {
        $doc = JFactory::getDocument();

        JHTML::_('behavior.framework');
        JHtml::_('jquery.framework');
        JHtml::_('jquery.ui');
        JHtml::_('bootstrap.framework');




        JText::script('COM_CHECKOUT_FIELD_EMPTY');
        JText::script('COM_CHECKOUT_FIELD_INCORRECT');
        JText::script('COM_CHECKOUT_FIELD_INCORRECT_RFC');
        JText::script('COM_CHECKOUT_FIELD_INCORRECT_BIRTHDAY');
        JText::script('COM_CHECKOUT_FIELD_INCORRECT_BIRTHDAY_NOT_MATCH');
        JText::script('COM_CHECKOUT_FIELD_INCORRECT_CELLPHONE');

        $css = $this->_getCSSPath('delivery.css', 'checkoutoverride');
        $js = $this->_getJSPath('delivery.js', 'checkoutoverride');
    
        if ($css) {
            $doc->addStyleSheet($css);
        }
        if ($js) {
            $doc->addScript($js);
        }
         $doc->addScript($this->_getJSPath('sweetalert2.min.js', 'checkoutoverride'));

       $doc->addStyleSheet($this->_getCSSPath("sweetalert2.min.css",'checkoutoverride','css'));

        $doc->addStyleDeclaration($css);
   
    }

    public static function _getJSPath($jsfile, $component) {
        $bPath = 'plugins/system/' . $component . '/assets/js/' . $jsfile;
        if (file_exists(JPATH_BASE . '/' . $bPath)) {
            return JURI::Root(true) . '/' . $bPath . '?t=' . time();
        } else {
            return false;
        }
    }

    public static function _getCSSPath($cssfile, $component) {
        $bPath = 'plugins/system/' . $component . '/assets/css/' . $cssfile;
        if (file_exists(JPATH_BASE . '/' . $bPath)) {
            return JURI::Root(true) . '/' . $bPath . '?t=' . time();
        } else {
            return false;
        }
    }

    private function hasDineroMovil($dineroMovilSku, $cartModel) {

        var_dump($cartModel->getCartItems());
        die();
    }

}
