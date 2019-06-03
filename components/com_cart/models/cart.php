<?php
defined('_JEXEC') or die;

class CartModelCart extends JModelLegacy
{
  protected static $cartTable = '#__core_user_cart_items';
  protected static $productTable = 'core_products';
  protected static $configsTable = '#__core_configs';
  protected static $ProductxRoleTable = 'core_products_x_roles';
  protected static $CategoryxRoleTable = 'core_product_categories_x_roles';
  protected static $productCategoryTable = 'core_products_x_categories';
  protected static $CategoryTable = 'core_product_categories';
  protected static $stockTable = '#__core_products_stock';

  public static function getCartItems()
  {
    $results = array();
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('b.id', 'b.title', 'b.sku, a.quantity, 
        b.file_name, b.price, a.quantity*b.price as lineTotal, a.product_id'))
      ->from($db->quoteName(self::$cartTable, 'a'))
      ->join('INNER', $db->quoteName(self::$productTable, 'b') . ' ON (' . 
        $db->quoteName('a.product_id') . ' = ' . 
        $db->quoteName('b.id') . ')')
      ->where('a.user_id = ' . $db->Quote($user))
      ->order($db->quoteName('b.title') . ' ASC');

      $db->setQuery($query);

      $results = $db->loadObjectList();

      if (!empty($results)) {
        foreach ($results as $product) {
          $price = self::getRolesPrice($product->product_id ,$db);
          if (!is_null($price)){
            $product->price = $price;
            $product->lineTotal = $product->price * $product->quantity;
          }
        }
      }

      $total = 0;
      foreach ($results as $item){
        $total += $item->lineTotal;
      }

      $results['items'] = $results;
      $results['lineTotals'] = $total;
    }

    return $results;
  }

  public static function updateCartItem($params){
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $fields = array(
        $db->quoteName('quantity') . ' = ' . $db->quote($params['quantity'])
      );

      $conditions = array(
        $db->quoteName('user_id') . ' = ' . $db->quote($user), 
        $db->quoteName('product_id') . ' = ' . $db->quote($params['id'])
      );

      $query->update($db->quoteName(self::$cartTable))
      ->set($fields)->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }

  public static function emptyCart(){
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $conditions = array(
        $db->quoteName('user_id') . ' = ' . $db->quote($user)
      );

      $query->delete($db->quoteName(self::$cartTable));
      $query->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }

  public static function deleteCartItem($params){
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $conditions = array(
        $db->quoteName('user_id') . ' = ' . $db->quote($user), 
        $db->quoteName('product_id') . ' = ' . $db->quote($params['id'])
      );

      $query->delete($db->quoteName(self::$cartTable));
      $query->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }

  public static function createCart($params){
    $user = JFactory::getUser()->id;
    $exists = self::cartExists($params['product']);
    $product = self::getProduct($params['product']);
    
    if (!$exists && $user > 0 && !is_null($product)) {
      $cart = new stdClass();
      $cart->user_id = $user;
      $cart->product_id = $params['product'];
      $cart->quantity = $params['quantity'];

      $result = JFactory::getDbo()
      ->insertObject(self::$cartTable, $cart);
    }
  }

  public static function getProduct($product_id){
    $results = array();
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('U.id, U.sku, U.title, U.description,'.
        'U.brand, U.file_name, U.price, CAT.id AS cat, CAT.name'))
      ->from($db->quoteName(self::$productTable, 'U'))
      ->join('INNER', $db->quoteName(self::$productCategoryTable, 'PC') . ' ON (' . 
        $db->quoteName('PC.product_id') . ' = ' . 
        $db->quoteName('U.id') . ')')
      ->join('INNER', $db->quoteName(self::$CategoryTable, 'CAT') . ' ON (' . 
        $db->quoteName('PC.category_id') . ' = ' . 
        $db->quoteName('CAT.id') . ')')
      ->where('U.id = ' . $db->Quote($product_id))
      ->order($db->quoteName('U.title') . ' ASC');

      $query = self::setCategoriesRoles($query, $db);
      $query = self::setStock($query, $db);
      $db->setQuery($query);
      $results = $db->loadObject();
    }
    return $results;
  }

  public static function setStock($query, $db){
    $query 
    ->join('INNER', $db->quoteName(self::$stockTable, 's') . ' ON (' . 
      $db->quoteName('U.id') . ' = ' . 
      $db->quoteName('s.product_id') . ')')
    ->where("s.stock > 0");

    return $query;
  }

  public static function getCategoriesRoles($roles, $db){
    $results = null;
    foreach ($roles['array'] as $rol) {
      $queryRoles = $db->getQuery(true);
      $queryRoles
      ->select(array('CXR.id, CXR.rol_id, CXR.category_id'))
      ->from($db->quoteName(self::$CategoryxRoleTable, 'CXR'))
      ->where('CXR.rol_id = ' . $db->Quote($rol));
      $db->setQuery($queryRoles);
      $results = $db->loadObject();
    }
    return $results;
  }

  public static function setCategoriesRoles($query, $db){
    $roles = self::getRoles();
    $results = self::getCategoriesRoles($roles, $db);
    if (!is_null($results)) {
      $query
      ->join('INNER', $db->quoteName(self::$CategoryxRoleTable, 'CXR') . ' ON (' . 
        $db->quoteName('PC.category_id') . ' = ' . 
        $db->quoteName('CXR.category_id') . ')')
      ->where($db->quoteName('CXR.rol_id').' IN ' . '('.$roles['string'].')');
    }

    return $query;
  }

  public static function cartExists($product_id){
    $cart = self::getCartItem($product_id);
    return empty($cart)?false:true;
  }

  public static function getCartItem($product_id){
    $results = array();
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('a.id'))
      ->from($db->quoteName(self::$cartTable, 'a'))
      ->where('a.user_id = ' . $db->Quote($user) . 
        ' and a.product_id = ' . $db->Quote($product_id));

      $db->setQuery($query);

      $results = $db->loadObjectList();
    }

    return $results;
  }

  public static function getConfig($key){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('c.id, c.key, c.value'))
    ->from($db->quoteName(self::$configsTable, 'c'))
    ->where('c.key = ' . $db->Quote($key))
    ->order($db->quoteName('c.key') . ' ASC');

    $db->setQuery($query);

    $results = $db->loadObject();
    return $results;
  }

  public static function getRoles(){
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

  public static function getRolesPrice($product_id, $db){
    $results = null;
    $price = null;
    $roles = self::getRoles();
    foreach ($roles['array'] as $rol) {
      $queryRoles = $db->getQuery(true);
      $queryRoles
      ->select(array('PXR.id, PXR.rol_id, PXR.product_id, PXR.price'))
      ->from($db->quoteName(self::$ProductxRoleTable, 'PXR'))
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