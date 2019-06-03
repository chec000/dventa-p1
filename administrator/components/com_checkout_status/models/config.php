<?php
defined('_JEXEC') or die;

class Checkout_StatusModelConfig extends JModelLegacy
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

  public static function updateConfig($key, $value){
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $fields = array(
      $db->quoteName('value') . ' = ' . $db->quote($value)
    );

    $conditions = array(
      $db->quoteName('key') . ' = ' . $db->quote($key)
    );

    $query->update($db->quoteName(self::$configsTable))
    ->set($fields)->where($conditions);

    $db->setQuery($query);

    $result = $db->execute();
  }

  public static function insertConfig($key, $value, $visibility)
  {
   $db = JFactory::getDbo();
   $config = new stdClass();
   $config->key = $key;
   $config->value = $value;
   $config->visibility = $visibility;
   $db->insertObject(self::$configsTable, $config);
 }
}