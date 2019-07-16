<?php

defined('_JEXEC') or die('Restricted access');

class CheckoutViewConfirm extends JViewLegacy {

    function display($tpl = null) {
        $this->load_assets();

        $userId = JFactory::getUser()->id;
        $jinput = JFactory::getApplication()->input;

        if ($userId > 0) {
            $this->showPrice = $this->getPriceShow();
            $configs = $this->getModel('Config');
            $this->delivery_mode = is_null($configs->getConfig('checkout.delivery.mode')) ?
                    null : $configs->getConfig('checkout.delivery.mode')->value;

            $this->currency = $this->getCurrency();
            $cart = $this->getModel('Cart');
            $cart_data = $cart->getCartItems();
            $this->cartItems = $cart_data['items'];
            $this->lineTotals = $cart_data['lineTotals'];

            if (isset($this->delivery['cedisId'])) {
                $this->cedis = $this->loadCedis($this->delivery['cedisId']);
            }
            $deliveryModel = $this->getModel('Delivery');
            $this->productTypes = $deliveryModel->getProductTypes();
            $this->delivery_info = $this->getDeliveryInfo($this->delivery_mode, $this->delivery);

            $this->delivery_info = array_merge($this->delivery_info, $jinput->getArray());
            $this->setUserData();            
            
            if ($this->delivery_info['id'] == '' || $this->delivery_info['userId'] == '') {
               
                JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_checkout', false));        
            }

        } else {
            $this->userId = $userId;
        }
        
        $this->addTemplatePath(__DIR__ . '/tmpl/');
        parent::display();
    }
    private function setUserData()
    {
        $user=$this->getUser();
       
        if ($user!=null) {
          $name= JFactory::getUser()->name;
          $user_name=$name.' '.$user->last_name1.' '.$user->last_name2;            
        $this->delivery_info['user_name']=$user_name;
        $this->delivery_info['dob']=$user->dob;
        $this->delivery_info['rfc']=$user->rfc;            
        $this->delivery_info['correo']=JFactory::getUser()->email;
        }else{
        $this->delivery_info['user_name']="";
        $this->delivery_info['correo']="";
        $this->delivery_info['dob']="";
        $this->delivery_info['rfc']="";
        }
    }

    public function getPriceShow() {
        $configs = JModelLegacy::getInstance('Config', 'CheckoutModel');
        $value = is_null($configs->getConfig('catalog.productprice.show')) ? '0' : $configs->getConfig('catalog.productprice.show')->value;
        return $value;
    }

    public function getCurrency() {
        $configs = $this->getModel('Config');
        $currency = is_null($configs->getConfig('pmr.coin.name')) ? "" : $configs->getConfig('pmr.coin.name')->value;
        return $currency;
    }

    public function getDeliveryInfo($mode, $data) {
        $delivery_info = array();
        if ($mode == 'user-address') {
            $delivery_info = $this->loadUser($data);
        } else {
            if (isset($data['cedisId'])) {
                $cedisId = $data['cedisId'];
                $cedis = $this->loadCedis($cedisId);
                $delivery_info = array(
                    'id' => $cedis->id,
                    'cedis' => $cedis->names_cedis,
                    'city' => $cedis->city,
                    'estate' => $cedis->estate,
                    'userId' => 'N/A'
                );
            } else {
                $delivery_info = array(
                    'id' => '',
                    'cedis' => '',
                    'city' => '',
                    'state' => '',
                    'userId' => 'N/A'
                );
            }
        }
        return $delivery_info;
    }

    public function loadCedis($id) {
        $delivery = $this->getModel('Delivery');
        $cedis = $delivery->getCedis($id);
        return $cedis;
    }

    public function loadUser($data) {
      
        return  array(
            'id' => 'N/A',
            'userId' => JFactory::getUser()->id,
            'street' => isset($data['street']) ? $data['street'] : '',
            'num_ext' => isset($data['num_ext']) ? $data['num_ext'] : '',
            'num_int' => isset($data['num_int']) ? $data['num_int'] : '',
            'reference' => isset($data['reference']) ? $data['reference'] : '',
            'location' => isset($data['location']) ? $data['location'] : '',
            'zip_code' => isset($data['zip_code']) ? $data['zip_code'] : '',
            'city' => isset($data['city']) ? $data['city'] : '',
            'town' => isset($data['town']) ? $data['town'] : '',
            'state' => isset($data['state']) ? $data['state'] : '',
        );

    }

 private function getUser(){
    $user=null;
        try {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select('u.*')
                ->from($db->quoteName('#__core_user_info','u'))
                ->where($db->quoteName('u.user_id') . ' = ' . $db->quote(JFactory::getUser()->id))
                ->setLimit('1');
        $db->setQuery($query);
        $user = $db->loadObject();   
        } catch (Exception $e) {
            return null;
        }

      

        return $user;
    } 
    public function load_assets() {
        $doc = JFactory::getDocument();

        JHTML::_('behavior.framework');
        JHtml::_('jquery.framework');
        JHtml::_('jquery.ui');
        JHtml::_('bootstrap.framework');

    
        $css = $this->_getCSSPath('confirm.css', 'checkoutoverride');

        if ($css) {
            $doc->addStyleSheet($css);
        }
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

}
