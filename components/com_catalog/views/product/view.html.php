<?php
defined('_JEXEC') or die('Restricted access');

class catalogViewproduct extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->setLikes($this->product_id);
        $this->user = JFactory::getUser()->id;
        $this->load_assets();		
        $this->currency = $this->getCurrency();
        $this->product = $this->getProduct($this->product_id);
        $category_id = isset($this->product->cat)?$this->product->cat:null;
        $this->products_related = $this->getProductsRelated($category_id);
        $this->wishlistExist = $this->getWishlistItem($this->product_id);
        $this->stock = $this->getStock($this->product_id);
        $this->likeOption = $this->getLikes($this->product_id);
        $this->showPrice = $this->getPriceShow();
        $this->showBrand = $this->getBrandShow();
        $this->cartAdd = ProductHelper::getCheckoutState();
        parent::display();
    }

    public function getPriceShow()
    {
        $configs = JModelLegacy::getInstance('Config', 'CatalogModel');
        $value = is_null($configs->getConfig('catalog.productprice.show'))?'0':$configs->getConfig('catalog.productprice.show')->value;
        return $value;
    }

    public function getBrandShow()
    {
        $configs = JModelLegacy::getInstance('Config', 'CatalogModel');
        $value = is_null($configs->getConfig('catalog.productbrand.show'))?'0':$configs->getConfig('catalog.productbrand.show')->value;
        return $value;
    }

    public function setLikes($product_id)
    {
        $showLike = ProductHelper::getComponentParams('com_catalog', 'likes');
        if (isset($this->likeParams) && $showLike == 1) {
            $likeModel = JModelLegacy::getInstance('Like', 'CatalogModel');
            $likeModel->setLike($product_id, $this->likeParams['option']);
        }
    }

    public function getLikes($product_id)
    {
        $likeModel = JModelLegacy::getInstance('Like', 'CatalogModel');
        $like = $likeModel->getLike($product_id);
        if (isset($like->option)) {
            switch ($like->option) {
                case 'like':
                return 'up';
                break;
                case 'dislike':
                return 'down';
                break;
            }
        }
        return $like;
    }

    public function getStock($product_id)
    {
        $showStock = ProductHelper::getComponentParams('com_cart', 'show_stock');
        if ($showStock != 1) {
            return null;
        }
        else
        {
            $stockModel = JModelLegacy::getInstance('Stock', 'CatalogModel');
            $stock = $stockModel->getStock($product_id);
            return isset($stock->stock)?$stock->stock:null;
        }
    }

    public function getWishlistItem($product_id)
    {
        $componentConfig = ProductHelper::getComponentParams('com_wishlist', 'wishlist_enable');
        switch ($componentConfig) {
            case '0':
            return true;
            break;
            case '1':
            $list = JModelLegacy::getInstance('Wishlist', 'CatalogModel');
            return $list->itemExists($product_id);
            break;
        }
        return true;
    }

    public function getCurrency()
    {
        $configs = JModelLegacy::getInstance('Config', 'CatalogModel');
        $currency = is_null($configs->getConfig('pmr.coin.name'))?"":$configs->getConfig('pmr.coin.name')->value;
        return $currency;
    }
    
    public function getProduct($product_id)
    {
        $products = JModelLegacy::getInstance('Products', 'CatalogModel');
        $product = $products->getProduct($product_id);
        return $product;
    }

    public function getProductsRelated($category_id)
    {
        $products = JModelLegacy::getInstance('Products', 'CatalogModel');
        $productsRelated = $products->getProductsRelated($category_id);
        return $productsRelated;
    }

    public function load_assets()
    {
        $doc = JFactory::getDocument();
        $css = $this->_getCSSPath('com_products.css', 'com_catalog');
        $js = $this->_getJSPath('com_products.js', 'com_catalog');
        $doc->addScript($js);
        if ($css) {
            $doc->addStyleSheet($css);
        }
        if ($js) {
            $doc->addScript($js);
        }
        $doc->addStyleDeclaration($css);
    }

    public static function _getJSPath($jsfile, $component)
    {
        $bPath = 'components/' . $component . '/assets/js/' . $jsfile;
        if (file_exists(JPATH_BASE . '/' . $bPath)) {
            return JURI::Root(true) . '/' . $bPath;
        } else {
            return false;
        }
    }

    public static function _getCSSPath($cssfile, $component)
    {
        $bPath = 'components/' . $component . '/assets/css/' . $cssfile;
        if (file_exists(JPATH_BASE . '/' . $bPath)) {
            return JURI::Root(true) . '/' . $bPath;
        } else {
            return false;
        }
    }
}