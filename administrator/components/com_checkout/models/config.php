<?php
defined('_JEXEC') or die;

class CheckoutModelConfig extends JModelLegacy
{
  protected static $configsTable = '#__core_configs';

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
}