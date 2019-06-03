<?php
defined('_JEXEC') or die;

class WishlistModelProduct extends JModelLegacy
{
	protected $productsTable = 'core_products';
	protected $productxRoleTable = 'core_products_x_roles';
	protected $productCategoryTable = 'core_products_x_categories';
	protected $categoryTable = 'core_product_categories';
	protected $categoryxRoleTable = 'core_product_categories_x_roles';
	protected $stockTable = '#__core_products_stock';

	public function getProducts($product_id_list){

		$results = array();
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('U.id, U.sku, U.title, U.description,'.
				'U.brand, U.file_name, U.price, U.real_price, U.payload'))
			->from($db->quoteName($this->productsTable, 'U'))
			->where($db->quoteName('U.id').' IN ' . '('.$product_id_list.')');

			$db->setQuery($query);
			$results = $db->loadObjectList();

			if (!empty($results)) {
				foreach ($results as $product) {
					$price = $this->getRolesPrice($product->id ,$db);
					if (!is_null($price))
						$product->price = $price;
				}
			}
		}
		return $results;
	}

	public function getProduct($product_id){
		$results = array();
		$user = JFactory::getUser()->id;
		if ($user > 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
			->select(array('p.id, p.sku, p.title, p.description,'.
				'p.brand, p.file_name, p.price, CAT.id AS cat, CAT.name, p.real_price, p.payload'))
			->from($db->quoteName($this->productsTable, 'p'))
			->join('INNER', $db->quoteName($this->productCategoryTable, 'PC') . ' ON (' . 
				$db->quoteName('PC.product_id') . ' = ' . 
				$db->quoteName('p.id') . ')')
			->join('INNER', $db->quoteName($this->categoryTable, 'CAT') . ' ON (' . 
				$db->quoteName('PC.category_id') . ' = ' . 
				$db->quoteName('CAT.id') . ')')
			->where('p.id = ' . $db->Quote($product_id))
			->order($db->quoteName('p.title') . ' ASC');

			$query = $this->setCategoriesRoles($query, $db);
			$query = $this->setStock($query, $db);
			$db->setQuery($query);
			$results = $db->loadObject();

			if (!is_null($results)) {
				$price = $this->getRolesPrice($product_id ,$db);
				if (!is_null($price))
					$results->price = $price;
			}
		}
		return $results;
	}

	public function setProduct($query, $db)
	{
		$query 
		->join('INNER', $db->quoteName($this->productsTable, 'p') . ' ON (' . 
			$db->quoteName('j.product_id') . ' = ' . 
			$db->quoteName('p.id') . ')');
		return $query;
	}

	public function setStock($query, $db){
		$query 
		->join('INNER', $db->quoteName($this->stockTable, 's') . ' ON (' . 
			$db->quoteName('p.id') . ' = ' . 
			$db->quoteName('s.product_id') . ')')
		->where("s.stock > 0");
		return $query;
	}

	public function setCategoriesRoles($query, $db){
		$roles = $this->getRoles();
		$results = $this->getCategoriesRoles($roles, $db);
		if (!is_null($results)) {
			$query
			->join('INNER', $db->quoteName($this->categoryxRoleTable, 'CXR') . ' ON (' . 
				$db->quoteName('PC.category_id') . ' = ' . 
				$db->quoteName('CXR.category_id') . ')')
			->where($db->quoteName('CXR.rol_id').' IN ' . '('.$roles['string'].')');
		}
		return $query;
	}

	public function getCategoriesRoles($roles, $db){
		$results = null;
		foreach ($roles['array'] as $rol) {
			$queryRoles = $db->getQuery(true);
			$queryRoles
			->select(array('CXR.id, CXR.rol_id, CXR.category_id'))
			->from($db->quoteName($this->categoryxRoleTable, 'CXR'))
			->where('CXR.rol_id = ' . $db->Quote($rol));
			$db->setQuery($queryRoles);
			$results = $db->loadObject();
		}
		return $results;
	}

	public function getRoles(){
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

	public function getRolesPrice($product_id, $db){
		$results = null;
		$price = null;
		$roles = $this->getRoles();
		foreach ($roles['array'] as $rol) {
			$queryRoles = $db->getQuery(true);
			$queryRoles
			->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
			->from($db->quoteName($this->productxRoleTable, 'PXR'))
			->where('PXR.rol_id = ' . $db->Quote($rol))
			->where('PXR.product_id = ' . $db->Quote($product_id));

			$db->setQuery($queryRoles);
			$results = $db->loadObject();
			if (!is_null($results)) {
				$price = $results->price;
			}
		}
		return $price;
	}
}