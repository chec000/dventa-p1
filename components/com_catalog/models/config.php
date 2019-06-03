<?php
defined('_JEXEC') or die;

class CatalogModelConfig extends JModelLegacy
{
  protected $configsTable = '#__core_configs';

  public function getConfig($key){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('c.id, c.key, c.value'))
    ->from($db->quoteName($this->configsTable, 'c'))
    ->where('c.key = ' . $db->Quote($key))
    ->order($db->quoteName('c.key') . ' ASC');

    $db->setQuery($query);

    $results = $db->loadObject();
    return $results;
  }
}