<?php
defined('_JEXEC') or die;

class CheckoutModelStock extends JModelLegacy
{
  protected static $stockTable = '#__core_products_stock';

  public static function getStock($product_id){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('s.id, s.product_id, s.stock'))
    ->from($db->quoteName(self::$stockTable, 's'))
    ->where('s.product_id = ' . $db->Quote($product_id));

    $db->setQuery($query);

    $results = $db->loadObject();
    return $results;
  }

  public static function updateStock($params){
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $stock = is_null(self::getStock($params['product_id']))
    ?0:self::getStock($params['product_id'])->stock;
    
    $newStock = $stock - $params['quantity'];

    if ($newStock >= 0) {
      $fields = array(
        $db->quoteName('stock') . ' = ' . $db->quote($newStock)
      );

      $conditions = array(
        $db->quoteName('product_id') . ' = ' . $db->quote($params['product_id'])
      );

      $query->update($db->quoteName(self::$stockTable))
      ->set($fields)->where($conditions);

      $db->setQuery($query);

      $result = $db->execute();
    }
  }
}