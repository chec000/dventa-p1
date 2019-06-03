<?php
defined('_JEXEC') or die;

class CatalogModelStock extends JModelLegacy
{
  protected $stockTable = '#__core_products_stock';

  public function getStock($product_id){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('s.id, s.product_id, s.stock'))
    ->from($db->quoteName($this->stockTable, 's'))
    ->where('s.product_id = ' . $db->Quote($product_id));

    $db->setQuery($query);

    $results = $db->loadObject();
    return $results;
  }
}