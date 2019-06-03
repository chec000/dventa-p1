<?php
defined('_JEXEC') or die;

class CheckoutModelZipcode extends JModelLegacy
{
  protected static $zipCodeTable = '#__zip_codes';

  public static function getItems($search, $field, $params)
  {
    $results = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    if ($field == 'zip_code') {
      $query
      ->select(array('distinct(z.zip_code) as zip_code'))
      ->from($db->quoteName(self::$zipCodeTable, 'z'))
      ->order($db->quoteName('z.'.$field) . ' ASC');
    }else{
      $query
      ->select(array('z.zip_code, z.location, z.city, z.town, z.state'))
      ->from($db->quoteName(self::$zipCodeTable, 'z'))
      ->order($db->quoteName('z.'.$field) . ' ASC');

      if (!is_null($params['zip_code']))
        $query->where($db->qn('z.zip_code').' = '. $db->quote($params['zip_code']));

      if (!is_null($params['location']))
        $query->where($db->qn('z.location').' = '. $db->quote($params['location']));

      if (!is_null($params['city']))
        $query->where($db->qn('z.city').' = '. $db->quote($params['city']));
    }
    if ($field != '')
      $query->where($db->qn($field).' LIKE '. $db->quote($db->escape('%'.$search.'%')));
    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
  }

  public static function getStates()
  {
    $results = array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
    ->select(array('distinct(z.state)'))
    ->from($db->quoteName(self::$zipCodeTable, 'z'))
    ->order($db->quoteName('z.state') . ' ASC');

    $db->setQuery($query);

    $results = $db->loadObjectList();

    return $results;
  }
}