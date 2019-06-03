<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Adventa - Account_status Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	Adbox.Account_status
 */


class modAccount_statusHelper {

    public static function getExchanged()
    {
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        /*$exchanged=0;
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('amount')))
                    ->from($db->quoteName('#__core_user_transactions'))
                    ->where('user_id = ' . $db->Quote($user->id).' AND amount<'.$db->Quote('0'));
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();

        foreach ($result as $item){
            $exchanged+=$item->amount;
        }
        // Return the Hello
        $exchanged*= -1;
        echo $query; die();
        return $exchanged;*/

        $exchanged=0;
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('total')))
                    ->from($db->quoteName('#__core_orders'))
                    ->where('user_id = ' . $db->Quote($user->id).' AND deleted_at is NULL');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();

        foreach ($result as $item){
            $exchanged+=$item->total;
        }
        // Return the Hello
        //echo $query; die();
        //$exchanged*= -1;
        return $exchanged;
    }

    public static function getAdquired()
    {
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $adquired=0;
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('amount')))
                    ->from($db->quoteName('#__core_user_transactions'))
                    ->where('user_id = ' . $db->Quote($user->id).' AND type='.$db->Quote('result'));
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();

        foreach ($result as $item){
            $adquired+=$item->amount;
        }
        // Return the Hello
        return $adquired;
    }

    public static function getActual()
    {
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $actual=0;
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('amount')))
                    ->from($db->quoteName('#__core_user_transactions'))
                    ->where('user_id = ' . $db->Quote($user->id));

        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();

        foreach ($result as $item){
            $actual+=$item->amount;
        }
        // Return the Hello
        return $actual;
    }

    public static function getCoinName()
    {
      $user = JFactory::getUser();
      $db = JFactory::getDbo();

      $query = $db->getQuery(true)
                  ->select($db->quoteName('value'))
                  ->from($db->quoteName('#__core_configs'))
                  ->where($db->quoteName('key').' = "pmr.coin.name"');
      $db->setQuery($query);

      $data= $db->loadObject();

      if($data){
        return $data->value;
      }else{
        return false;
      }

    }

}
