<?php
defined('_JEXEC') or die;

class WishlistModelWishlist extends JModelLegacy
{

  protected $listTable = '#__core_user_wishlist_items';
  protected $ordersTable = '#__core_wishlist_orders';
  protected $orderProductsTable = '#__core_wishlist_order_products';
  protected $productsTable = 'core_products';

  public function getListItems()
  {
    $results = array();
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $productModel = JModelLegacy::getInstance('Product', 'WishlistModel');
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('p.id', 'p.title', 'p.sku, j.quantity, 
        p.file_name, p.price, j.quantity*p.price as lineTotal, j.product_id'))
      ->from($db->quoteName($this->listTable, 'j'))
      ->where('j.user_id = ' . $db->Quote($user))
      ->order($db->quoteName('p.title') . ' ASC');

      $query =  $productModel->setProduct($query, $db);

      $db->setQuery($query);

      $results = $db->loadObjectList();

      if (!empty($results)) {
        foreach ($results as $product) {
          $price = $productModel->getRolesPrice($product->product_id ,$db);
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

  public function getListItemsByProducts($product_id_list)
  {
    $results = array();
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $productModel = JModelLegacy::getInstance('Product', 'WishlistModel');
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('p.id', 'p.title', 'p.sku, j.quantity, 
        p.file_name, p.price, j.quantity*p.price as lineTotal, j.product_id'))
      ->from($db->quoteName($this->listTable, 'j'))
      ->where('j.user_id = ' . $db->Quote($user))
      ->where($db->quoteName('j.product_id').' IN ' . '('.$product_id_list.')')
      ->order($db->quoteName('p.title') . ' ASC');

      $query =  $productModel->setProduct($query, $db);
      $query =  $productModel->setStock($query, $db);

      $db->setQuery($query);

      $results = $db->loadObjectList();

      if (!empty($results)) {
        foreach ($results as $product) {
          $price = $productModel->getRolesPrice($product->product_id ,$db);
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

  public function deleteListItem($product_id){
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $conditions = array(
        $db->quoteName('user_id') . ' = ' . $db->quote($user), 
        $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
      );

      $query->delete($db->quoteName($this->listTable));
      $query->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }

  public function deleteListItems($product_id_list){
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $conditions = array(
        $db->quoteName('user_id') . ' = ' . $db->quote($user), 
        $db->quoteName('product_id') . ' IN (' . $product_id_list . ')'
      );

      $query->delete($db->quoteName($this->listTable));
      $query->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }

  public function createList($params){
    $user = JFactory::getUser()->id;
    $exists = $this->itemExists($params['product']);
    $productModel = JModelLegacy::getInstance('Product', 'WishlistModel');
    $product = $productModel->getProduct($params['product']);

    if (!$exists && $user > 0 && !is_null($product)) {
      $list = new stdClass();
      $list->user_id = $user;
      $list->product_id = $params['product'];
      $list->quantity = $params['quantity'];

      $result = JFactory::getDbo()
      ->insertObject($this->listTable, $list);
    }
  }

  public function itemExists($product_id){
    $list = $this->getListItem($product_id);
    return empty($list)?false:true;
  }

  public function getListItem($product_id)
  {
    $results = array();
    $user = JFactory::getUser()->id;
    if ($user > 0) {
      $productModel = JModelLegacy::getInstance('Product', 'WishlistModel');
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('p.id', 'p.title', 'p.sku, j.quantity, 
        p.file_name, p.price, j.quantity*p.price as lineTotal, j.product_id'))
      ->from($db->quoteName($this->listTable, 'j'))
      ->where('j.user_id = ' . $db->Quote($user))
      ->where('j.product_id = ' . $db->Quote($product_id))
      ->order($db->quoteName('p.title') . ' ASC');

      $query =  $productModel->setProduct($query, $db);
      $query =  $productModel->setStock($query, $db);

      $db->setQuery($query);

      $results = $db->loadObject();

      if (!empty($results)) {
        $price = $productModel->getRolesPrice($product_id ,$db);
        if (!is_null($price)){
          $results->price = $price;
          $results->lineTotal = $results->price * $results->quantity;
        }
      }
    }
    return $results;
  }

  public function getOrder($id)
  {
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query
    ->select(array('o.id, o.user_id, o.created_by_id, o.total, o.revision, o.deleted_at, o.deleted_at'))
    ->from($db->quoteName($this->ordersTable, 'o'))
    ->where('o.id = ' . $db->Quote($id));

    $db->setQuery($query);
    $results = $db->loadObject();
    return $results;
  }

  public function getProducts($orderId)
  {
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query
    ->select(array('o.id, o.order_id, p.id, p.sku, p.title, p.file_name, o.price, o.quantity, o.price*o.quantity as total'))
    ->from($db->quoteName($this->orderProductsTable, 'o')) 
    ->join('INNER', $db->quoteName($this->productsTable, 'p') . ' ON (' . 
      $db->quoteName('p.id') . ' = ' . 
      $db->quoteName('o.product_id') . ')')
    ->where('o.order_id = ' . $db->Quote($orderId));

    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
  }
}