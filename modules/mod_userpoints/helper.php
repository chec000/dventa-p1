<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Adventa - Userpoints Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	Adbox.Userpoints
 */

class modUserpointsHelper {

    public static function getAvailablePoints()
    {
      $user = JFactory::getUser();
      $db = JFactory::getDbo();

      $query = $db->getQuery(true)
                  ->select('SUM(amount) AS points')
                  ->from($db->quoteName('#__core_user_transactions'))
                  ->where($db->quoteName('user_id')." = '".$user->id."'");
      $db->setQuery($query);

      return (int)$db->loadResult();

    }

    public static function coinName(){

      $db = JFactory::getDbo();

      $query = $db->getQuery(true)
                  ->select('value')
                  ->from($db->quoteName('#__core_configs'))
                  ->where($db->quoteName('key')." = 'pmr.coin.name'");
      $db->setQuery($query);

      return $db->loadResult();

    }


}
