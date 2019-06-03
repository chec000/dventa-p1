<?php
defined('_JEXEC') or die('Restricted access');

class catalogViewproducts extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->setLikes();
		$this->user = JFactory::getUser()->id;
		$this->load_assets();
		$this->currency = $this->getCurrency();

		$params = $this->params;
		$params['page_size'] = '1000';

		$paramsP = $this->params;
		$paramsP['page_size'] = '1000';
		$paramsP['categories'] = '';

		$paramsR = $this->params;
		$paramsR['page_size'] = '1000';
		$paramsR['minPrice'] = 'min';
		$paramsR['maxPrice'] = 'max';
		$paramsR['categories'] = '';

		$this->productsCount = count($this->getProductsForFilter($params));
		$productsFilter = $this->getProductsForFilter($paramsP);

		$products_data = $this->getProducts($this->params);
		$this->products = $products_data['products'];
		$this->categories = $this->getCategories($this->params, $productsFilter);

		$priceRange = $this->getPriceRange($this->params, $this->getProductsForFilter($paramsR));
		$this->maxPriceRange = $priceRange['max'];
		$this->minPriceRange = $priceRange['min'];

		$price = $this->getPrice($this->params, $productsFilter);
		$this->maxPrice = $price['max'];
		$this->minPrice = $price['min'];

		$this->pages = $products_data['pages'];
		$this->pagesSize = ['9','18','36','72','144','288'];

		$pagesCount = isset($this->pages['pages_count'])?$this->pages['pages_count']:null;
		$this->numbers = $this->getPageItems($pagesCount, (int)$this->params['page'],$this->pages);
		$this->showPrice = $this->getPriceShow();
		$this->showBrand = $this->getBrandShow();
                $this->showPaginator = $this->getPaginatorShow();
                
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

	public function getPaginatorShow()
	{
		$configs = JModelLegacy::getInstance('Config', 'CatalogModel');
		$value = is_null($configs->getConfig('catalog.productpaginator.show'))?'top':$configs->getConfig('catalog.productpaginator.show')->value;
		return $value;
	}
        
	public function setLikes()
	{
		$showLike = ProductHelper::getComponentParams('com_catalog', 'likes');
		$product_id = isset($this->product_id)?$this->product_id:null;
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

	public function getCurrency()
	{
		$configs = JModelLegacy::getInstance('Config', 'CatalogModel');
		$currency = is_null($configs->getConfig('pmr.coin.name'))?"":$configs->getConfig('pmr.coin.name')->value;
		return $currency;
	}

	public function getPageItems($pages, $page, $totalpages)
	{
		$totalpages = isset($totalpages['pages_count'])?$totalpages['pages_count']:0;
		if ($pages >= 3) {
			$pages = 3;
		}
		$pages_items = array();
		for ($i=0; $i <= $pages - 1 ; $i++) { 
			$number = $i + $page + 1;
			if ($number <= $totalpages) {
				$pages_items[$i] = $number;
			}
		}

		return $pages_items;
	}

	public function getPriceRange($params, $products)
	{
		$minValue = $this->minOfKey($products, 'price');
		$maxValue = $this->maxOfKey($products, 'price');
		$price['min'] = $minValue;
		$price['max'] = $maxValue;
		return $price;
	}

	public function getPrice($params, $products)
	{
		$price = null;
		if ($params['minPrice'] == 'min') 
			$price['min'] = $this->minOfKey($products, 'price');
		else
			$price['min'] = $params['minPrice'];

		if ($params['maxPrice'] == 'max') 
			$price['max'] = $this->maxOfKey($products, 'price');
		else
			$price['max'] = $params['maxPrice'];
		return $price;
	}

	public function maxOfKey($array, $key) {
		$max = 0;
		if (!empty($array)) {
			$max = $array[0]->price;
			foreach($array as $a) {
				if($a->$key > $max) {
					$max = $a->$key;
				}
			}
		}
		return $max;
	}
	
	public function minOfKey($array, $key) {
		$min = 0;
		if (!empty($array)) {
			$min = $array[0]->price;
			foreach($array as $a) {
				if($a->$key < $min) {
					$min = $a->$key;
				}
			}
		}
		return $min;
	}

	public function getProducts($params)
	{
		$productsModel = JModelLegacy::getInstance('Products', 'CatalogModel');
		$products = $productsModel->getProducts($params);
		$data['products'] = !empty($products['items'])?$products['items']:array();
		$data['pages'] = !empty($products['pages'])?$products['pages']:array();
		return $data;
	}

	public function getProductsForFilter($params = array())
	{
		if (!isset($params['page_size'])) {
			$params['page_size'] = '1000';
		}
		if (!isset($params['categories'])) {
			$params['categories'] = '';
		}
		if (!isset($params['minPrice'])) {
			$params['minPrice'] = 'min';
		}
		if (!isset($params['maxPrice'])) {
			$params['maxPrice'] = 'max';
		}
		if (!isset($params['search'])) {
			$params['search'] = '';
		}
		$params['page'] = '1';
		$productsModel = JModelLegacy::getInstance('Products', 'CatalogModel');
		$products = $productsModel->getProducts($params);
		return !empty($products['items'])?$products['items']:array();
	}

	public function getCategories($params, $products)
	{
		$categories_name = array_count_values(
			array_map(
				function($value)
				{
					return $value->name;
				}, 
				$products)
		);
		$categories = array();
		$i = 0;
		$total_product = 0;
		foreach ($categories_name as $key => $value) {
			$categories[$i]['name'] = $key;
			$categories[$i]['products'] = $value;
			$categories[$i]['id'] = $this->getCategoryByName($key, $products);
			$categories[$i]['checked'] = $this->getCheckCategoryStatus($categories[$i]['id'], $params['categories']);
			$i++;
		}

		$categories['items'] = $this->orderByKey($categories, 'name','asc');
		return $categories;
	}

	public function getCheckCategoryStatus($categoryId, $params)
	{
		$categories = explode(",", $params);
		if (in_array($categoryId, $categories) !== false || $params == 'all' || $params == '') {
			return 'checked';
		}
		else{
			return '';
		}
	}

	public function orderByKey($data, $sortKey, $sort_flags)
	{
		if (empty($data) or empty($sortKey)) return $data;
		$ordered = array();
		foreach ($data as $key => $value)
			$ordered[$value[$sortKey]] = $value;

		if ($sort_flags == 'asc')
			ksort($ordered);
		elseif ($sort_flags == 'desc') 
			krsort($ordered);

		return array_values($ordered); 
	}

	public function getCategoryByName($name, $products)
	{
		$id = 0;
		foreach ($products as $key => $value) {
			if ($products[$key]->name == $name) {
				$id = $products[$key]->cat;
			}
		}
		return $id;
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