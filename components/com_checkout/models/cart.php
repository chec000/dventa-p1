<?php
defined('_JEXEC') or die;

class CheckoutModelCart extends JModelLegacy
{
  protected static $cartTable = '#__core_user_cart_items';
  protected static $productTable = 'core_products';
  protected static $ProductxRoleTable = 'core_products_x_roles';
  protected static $CategoryxRoleTable = 'core_product_categories_x_roles';
  protected static $productCategoryTable = 'core_products_x_categories';
  protected static $CategoryTable = 'core_product_categories';

  public static function getCartItems(){
    $results = array();
    $user = JFactory::getUser()->id;

    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('b.id', 'b.title', 'b.sku, a.quantity, 
        b.file_name, b.price, a.quantity*b.price as lineTotal, a.product_id, b.enabled'))
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