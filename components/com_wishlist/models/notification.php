<?php
defined('_JEXEC') or die;

class WishlistModelNotification extends JModelLegacy
{
  protected $notificationContentTable = '#__notification_content';

  public function getTemplae($key){
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('c.id, c.key, c.value'))
    ->from($db->quoteName($this->notificationContentTable, 'c'))
    ->where('c.key = ' . $db->Quote($key))
    ->where('c.visibility = 1')
    ->order($db->quoteName('c.key') . ' ASC');

    $db->setQuery($query);

    $results = $db->loadObject();
    
    return $results;
  }
}