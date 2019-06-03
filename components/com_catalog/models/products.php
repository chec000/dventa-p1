<?php
defined('_JEXEC') or die;

class CatalogModelProducts extends JModelLegacy
{

    protected $productTable = 'core_products';
    protected $productCategoryTable = 'core_products_x_categories';
    protected $CategoryTable = 'core_product_categories';
    protected $CategoryxRoleTable = 'core_product_categories_x_roles';
    protected $ProductxRoleTable = 'core_products_x_roles';
    protected $stockTable = '#__core_products_stock';

    public function setProduct($query, $db)
    {
        $query 
        ->join('INNER', $db->quoteName($this->productTable, 'U') . ' ON (' . 
            $db->quoteName('j.product_id') . ' = ' . 
            $db->quoteName('U.id') . ')');
        $query = $this->setStock($query, $db);
        return $query;
    }

    public function setField($db){
        $query = $db->getQuery(true);
        $query 
        ->select(array('U.id, U.sku, U.title, U.description,'.
            'U.brand, U.file_name, IFNULL(PXR.price, U.price) as price, CAT.id AS cat, CAT.name'))
        ->from($db->quoteName($this->productTable, 'U'))
        ->where("U.enabled = 1");        

        return $query;
    } 

    public function setStock($query, $db){
        $query 
        ->join('INNER', $db->quoteName($this->stockTable, 's') . ' ON (' . 
            $db->quoteName('U.id') . ' = ' . 
            $db->quoteName('s.product_id') . ')')
        ->where("s.stock > 0");

        return $query;
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

    public function getCategoriesRoles($roles, $db){
        $results = null;
        foreach ($roles['array'] as $rol) {
            $queryRoles = $db->getQuery(true);
            $queryRoles
            ->select(array('CXR.id, CXR.rol_id, CXR.category_id'))
            ->from($db->quoteName($this->CategoryxRoleTable, 'CXR'))
            ->where('CXR.rol_id = ' . $db->Quote($rol));
            $db->setQuery($queryRoles);
            $results = $db->loadObject();
        }
        return $results;
    }

    public function setCategoriesRoles($query, $db){
        $roles = $this->getRoles();
        $results = $this->getCategoriesRoles($roles, $db);
        if (!is_null($results)) {
            $query
            ->join('INNER', $db->quoteName($this->CategoryxRoleTable, 'CXR') . ' ON (' . 
                $db->quoteName('PC.category_id') . ' = ' . 
                $db->quoteName('CXR.category_id') . ')')
            ->where($db->quoteName('CXR.rol_id').' IN ' . '('.$roles['string'].')');
        }

        return $query;
    }

    public function setCategories($query, $params, $db){

        $categories = explode(',', $params['categories']);
        $query
        ->join('INNER', $db->quoteName($this->productCategoryTable, 'PC') . ' ON (' . 
            $db->quoteName('PC.product_id') . ' = ' . 
            $db->quoteName('U.id') . ')')
        ->join('INNER', $db->quoteName($this->CategoryTable, 'CAT') . ' ON (' . 
            $db->quoteName('PC.category_id') . ' = ' . 
            $db->quoteName('CAT.id') . ')');
        if($params['categories']!=='all')
            $query->where($db->quoteName('CAT.id').' IN ' . '('.$params['categories'].')');
        return $query;
    }  

    public function setSearch($query, $params, $db){
        if(!empty($params['search'])){
            $search = $db->Quote('%'.$db->escape($params['search'], true).'%');
            $query->where('(U.title LIKE '.$search.
                ' OR U.sku LIKE '.$search.
                ' OR U.brand LIKE '.$search.')');
        }
        return $query;
    }

    public function setOrder($query, $params, $db){
        if(!empty($params['sortOrder'])&&!empty($params['sortField'])){
            $query->order($db->quoteName('U.'.$params['sortField']) .' '. $params['sortOrder']);               
        }
        return $query;
    }

    public function setFilterPrice($query, $params, $db){
        $params['minPrice'] = $params['minPrice']==='min'?0:
        $params['minPrice'];
        $params['maxPrice'] = $params['maxPrice']==='max'?99999999999:
        $params['maxPrice'];

        $rol = '';
        $roles = $this->getRoles()['array'];
        foreach ($roles as $key => $value) {
            $rol = $value;
        }

        $query->join('LEFT', $db->quoteName($this->ProductxRoleTable, 'PXR') . ' ON (' . 
            $db->quoteName('PXR.product_id') . ' = ' . 
            $db->quoteName('U.id') . ')' .
            ' AND (' .  $db->quoteName('PXR.rol_id') . ' = ' . $db->Quote($rol) . ')');

        $query->where('IFNULL(PXR.price, U.price) BETWEEN ' . $db->Quote($params['minPrice']) . ' AND '. $db->Quote($params['maxPrice']));

        return $query;        
    }

    public function setPaginator($query, $params, $db){
        $FirstResult = $params['page_size'] * ($params['page']-1);
        $MaxResults = $params['page_size'];

        $query->setLimit($MaxResults, $FirstResult);

        return $query;
    }

    public function setPageCount($params){
        $db = JFactory::getDbo();
        $select = $db->getQuery(true);
        $select 
        ->select(array('COUNT(U.id) as contador'))
        ->from($db->quoteName($this->productTable, 'U'))
        ->where("U.enabled = 1");    
        $params = $this->setParams($params);
        $select = $this->setCategories($select, $params, $db);
        $select = $this->setCategoriesRoles($select, $db);
        $select = $this->setSearch($select, $params, $db);
        $select = $this->setOrder($select, $params, $db);
        $select = $this->setFilterPrice($select, $params, $db);
        $select = $this->setStock($select, $db);
        $db->setQuery($select);
        $result = $db->loadObject();
        $result = isset($result->contador)?(int)$db->loadObject()->contador:0;

        return $result;
    }

    public function getProducts($params){
        $params = $this->setParams($params);
        $results = array();
        $user = JFactory::getUser()->id;
        if ($user > 0) {
            $db = JFactory::getDbo();
            $select = $this->setField($db);
            $select = $this->setStock($select, $db);
            $select = $this->setCategories($select, $params, $db);
            $select = $this->setCategoriesRoles($select, $db);
            $select = $this->setSearch($select, $params, $db);
            $select = $this->setOrder($select, $params, $db);
            $select = $this->setFilterPrice($select, $params, $db);
            $select = $this->setPaginator($select, $params, $db);

            $count = $this->setPageCount($params);
            $page_count = ceil($count/$params['page_size']);

            $db->setQuery($select);

            $resultSet = $db->loadObjectList();

            if (!empty($resultSet)) {
                foreach ($resultSet as $product) {
                    $price = $this->getRolesPrice($product->id ,$db);
                    if (!is_null($price)){
                        $product->price = $price;
                    }
                }
            }

            $results = [
                'items' =>$resultSet,
                'pages' => [
                    'current' => $params['page'],
                    'pages_count' => $page_count
                ]
            ];
        }
        return $results;
    }

    private function setParams($params){
        $params['page'] = !isset($params['page'])||empty($params['page'])?1:
        (int)$params['page'];
        $params['page_size'] = !isset($params['page_size'])||empty($params['page_size'])?1:
        (int)$params['page_size'];        
        $params['search'] = !isset($params['search'])||empty($params['search'])
        ?'':$params['search'];
        $params['sortField'] = !isset($params['sortField'])||
        empty($params['sortField'])?'':$params['sortField'];
        $params['sortOrder'] = !isset($params['sortOrder'])||
        empty($params['sortOrder'])?'':$params['sortOrder'];
        $params['categories'] = !isset($params['categories'])||
        empty($params['categories'])?'all':$params['categories'];
        $params['minPrice'] = !isset($params['minPrice'])||
        empty($params['minPrice'])?'min':$params['minPrice'];
        $params['maxPrice'] = !isset($params['maxPrice'])||
        empty($params['maxPrice'])?'max':$params['maxPrice'];
        return $params;
    }  

    public function getProduct($product_id){
        $results = array();
        $user = JFactory::getUser()->id;
        if ($user > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
            ->select(array('U.id, U.sku, U.title, U.description,'.
                'U.brand, U.file_name, U.price, CAT.id AS cat, CAT.name'))
            ->from($db->quoteName($this->productTable, 'U'))
            ->join('INNER', $db->quoteName($this->productCategoryTable, 'PC') . ' ON (' . 
                $db->quoteName('PC.product_id') . ' = ' . 
                $db->quoteName('U.id') . ')')
            ->join('INNER', $db->quoteName($this->CategoryTable, 'CAT') . ' ON (' . 
                $db->quoteName('PC.category_id') . ' = ' . 
                $db->quoteName('CAT.id') . ')')
            ->where('U.id = ' . $db->Quote($product_id))
            ->order($db->quoteName('U.title') . ' ASC');

            $query = $this->setCategoriesRoles($query, $db);
            $query = $this->setStock($query, $db);
            $db->setQuery($query);
            $results = $db->loadObject();
            if (!is_null($results)) {
                $price = $this->getRolesPrice($results->id ,$db);
                if (!is_null($price))
                    $results->price = $price;
            }
        }
        return $results;
    }

    public function getRolesPrice($product_id, $db){
        $results = null;
        $price = null;
        $roles = $this->getRoles();
        foreach ($roles['array'] as $rol) {
            $queryRoles = $db->getQuery(true);
            $queryRoles
            ->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
            ->from($db->quoteName($this->ProductxRoleTable, 'PXR'))
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

    public function getProductsRelated($category_id){
        $results = array();
        $user = JFactory::getUser()->id;

        if ($user > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
            ->select(array('U.id, U.sku, U.title, U.description,'.
                'U.brand, U.file_name, U.price, CAT.id AS cat, CAT.name'))
            ->from($db->quoteName($this->productTable, 'U'))
            ->join('INNER', $db->quoteName($this->productCategoryTable, 'PC') . ' ON (' . 
                $db->quoteName('PC.product_id') . ' = ' . 
                $db->quoteName('U.id') . ')')
            ->join('INNER', $db->quoteName($this->CategoryTable, 'CAT') . ' ON (' . 
                $db->quoteName('PC.category_id') . ' = ' . 
                $db->quoteName('CAT.id') . ')')
            ->where('CAT.id = ' . $db->Quote($category_id))
            ->where("U.enabled = 1")
            ->order('RAND() LIMIT 4');

            $query = $this->setStock($query, $db);
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
}