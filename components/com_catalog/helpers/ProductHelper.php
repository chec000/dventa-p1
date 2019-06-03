<?php

/*
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 */
class ProductHelper
{
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function product(&$_input,&$_this)
    {
        $_this->product_id = JRequest::getVar('id');
        $vName = $_input->get('view', 'product');
        $_input->set('view', $vName);
        $view = $_this->getView('product','html');
        $view->product_id = $_this->product_id;
        $view->display();
    }  
    
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function products(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'products');
        $_input->set('view', $vName);
        $view = $_this->getView('products','html');
        $view->params = self::setParamsProducts();  
        $view->display();
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function like(&$_input,&$_this)
    {
        $orgView = JRequest::getVar('orgView');
        $_this->product_id = JRequest::getVar('id');
        $vName = $_input->get('view', $orgView);
        $_input->set('view', $vName);
        $view = $_this->getView($orgView,'html');
        $view->likeParams = self::setLikeParams();
        $view->params = self::setParamsProducts();
        $view->product_id = $_this->product_id;
        $view->display();
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function dislike(&$_input,&$_this)
    {
        $orgView = JRequest::getVar('orgView');
        $_this->product_id = JRequest::getVar('id');
        $vName = $_input->get('view', $orgView);
        $_input->set('view', $vName);
        $view = $_this->getView($orgView,'html');
        $view->likeParams = self::setDislikeParams();
        $view->params = self::setParamsProducts();
        $view->product_id = $_this->product_id;
        $view->display();
    }

    /**
     * 
     * @return type
     */
    public static function setLikeParams()
    {
        return array(
            'option' => 'like',
        );
    }

    /**
     * 
     * @return type
     */
    public static function setDislikeParams()
    {
        return array(
            'option' => 'dislike'
        );
    }
    
    /**
     * 
     * @return type
     */
    public static function setParamsProducts()
    {
        $minPrice = is_null(JRequest::getVar('minPrice'))?'min':JRequest::getVar('minPrice');
        $maxPrice = is_null(JRequest::getVar('maxPrice'))?'max':JRequest::getVar('maxPrice');
        if (self::getPriceShow() == 0) {
            $minPrice = 'min';
            $maxPrice = 'max';
        }

        return array(
            'page_size' => is_null(JRequest::getVar('Size'))?'9':
            JRequest::getVar('Size'),           
            'page'=> is_null(JRequest::getVar('page'))?'1':
            JRequest::getVar('page'),      
            'search' => is_null(JRequest::getVar('q'))?'':
            JRequest::getVar('q'),
            'sortField' => is_null(JRequest::getVar('field'))?'title':
            JRequest::getVar('field'), 			
            'sortOrder' => is_null(JRequest::getVar('sortOrder'))?'asc':
            JRequest::getVar('sortOrder'), 			
            'categories' => is_null(JRequest::getVar('categories'))?'all':
            (JRequest::getVar('categories')=='non'?'':JRequest::getVar('categories')),		
            'minPrice' => $minPrice, 			
            'maxPrice' => $maxPrice,
        );        
    }

    public static function getComponentParams($component, $key)
    {
        $params = JComponentHelper::getParams($component);
        return  $params[$key];
    }   

    public static function getImageClass()
    {
        $imgClass = self::getComponentParams('com_catalog', 'product-image');
        if (!is_null($imgClass)) {
            return $imgClass;
        }
    }

    private static function getPriceShow()
    {
        $configs = JModelLegacy::getInstance('Config', 'CatalogModel');
        $value = is_null($configs->getConfig('catalog.productprice.show'))?'0':$configs->getConfig('catalog.productprice.show')->value;
        return $value;
    }

    public static function getCheckoutState()
    {
        $status = self::getCheckoutStatexRol();
        if (is_null($status)) {
            $configs = JModelLegacy::getInstance('Config', 'CatalogModel');
            $start = is_null($configs->getConfig('checkout.date.start'))?null:$configs->getConfig('checkout.date.start')->value;
            $end = is_null($configs->getConfig('checkout.date.end'))?null:$configs->getConfig('checkout.date.end')->value;
            $status = self::checkInRange($start, $end, self::getTimestamp());
        }
        return $status;
    }

    private static function getCheckoutStatexRol()
    {
        $roles = self::getRoles();
        $checkoutStatusModel = JModelLegacy::getInstance('Checkout_State', 'CatalogModel');
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
