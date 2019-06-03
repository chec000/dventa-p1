<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Adventa - Historial de canje Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	Historialdecanje.Historial_canje
 */
class modHistorial_canjeHelper {

    public static function getOrders(){
        $user = JFactory::getUser();
        
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('id','created_at','total')))
                    ->from($db->quoteName('#__core_orders'))
                    ->where('user_id = ' . $db->Quote($user->id).' AND '.$db->quoteName('deleted_at') . ' IS NULL');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();
        // Return the Hello
        
        return $result;
    }

    public static function getCedis(){
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('profile_value')))
                    ->from($db->quoteName('#__user_profiles'))
                    ->where('user_id = ' . $db->Quote($user->id));
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObject();
        // Return the Hello
        
        return $result;
    }

    public static function getOrderDetails(){
        $user = JFactory::getUser();
        $orders_count = new stdClass();
        $sum =0;
        
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('id','created_at','total')))
                    ->from($db->quoteName('#__core_orders'))
                    ->where('user_id = ' . $db->Quote($user->id).' AND deleted_at is NULL');
        // Prepare the query
        $db->setQuery($query);
        // Load the row.
        $result = $db->loadObjectList();
        // Return the Hello

        for($i=0; $i<count($result);$i++){
            $var = $result[$i]->id;
            $orders_count->$var = $result[$i];
        }
        
        return $orders_count;
    }

    public static function getCedisValue(){
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $query = $db->getQuery(true);
            
        $query->select($db->quoteName('value'));
        $query->from($db->quoteName('#__core_configs'));
        $query->where($db->quoteName('key') . ' = '. $db->quote('checkout.delivery.mode'));
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if($result != null){
            return $result[0]->value;				
        }else{
            return '0';
        }
    }

    public static function getOrderItemsCount($id){
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $sum =0;
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('id','quantity')))
                    ->from($db->quoteName('#__core_order_products'))
                    ->where('order_id = ' . $db->Quote($id));
        // Prepare the query
        $db->setQuery($query);
        $result = $db->loadObjectList();
        //Products
        for($i=0; $i<count($result);$i++){
            $sum = $sum + $result[$i]->quantity;
        }
        return $sum;
    }

    public static function itemsById($id){
        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select($db->quoteName(array('id','sku','title','quantity','price')))
                    ->from($db->quoteName('#__core_order_products'))
                    ->where('order_id = ' . $db->Quote($id));
        // Prepare the query
        $db->setQuery($query);
        $result = $db->loadObjectList();
        //Products
        return $result;
    }

    public static function countOrderItems(){
        $orders = modHistorial_canjeHelper::getOrders();    
    
        //$orders_count =(object)array();
        $orders_count = new stdClass();
        
        for($i=0; $i<count($orders); $i++){
            $var = $orders[$i]->id;
            $orders_count->$var = modHistorial_canjeHelper::getOrderItemsCount($orders[$i]->id);
        }
        return $orders_count;
    }

    public static function getOrderItems(){
        $orders = modHistorial_canjeHelper::getOrders();    
        $orders_byid = new stdClass();
        
        for($i=0; $i<count($orders); $i++){
            $var = $orders[$i]->id;
            $orders_byid->$var = modHistorial_canjeHelper::itemsById($orders[$i]->id);
        }
        return $orders_byid;
    }

    public static function getProfileByKey($id,$key){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__user_profiles'));
		$query->where($db->quoteName('user_id') . ' = '. $db->quote($id).' AND '.$db->quoteName('profile_key') . ' = '. $db->quote($key));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if($result!=null){
            $str_clean = str_replace('"','',$result[0]->profile_value);
			return $str_clean;			
		}else{
            return '';
        }
		
    }
    
    public static function getCedisInfo($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
            
        $query->select('*');
        $query->from($db->quoteName('#__core_cedis'));
        $query->where($db->quoteName('cedis_id') . ' = '. $db->quote($id));
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if($result!=null){
            return $result[0];
        }else{
            return '';
        }
    }



}