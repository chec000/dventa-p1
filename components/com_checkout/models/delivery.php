<?php
defined('_JEXEC') or die;

class CheckoutModelDelivery extends JModelLegacy
{
    protected static $cedisTable = '#__core_cedis';

    public static function getCedisList(){
        $results = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
        ->select(array('c.id, c.cedis_id, c.names_cedis, c.street, 
            c.ext_number, c.int_number, c.location, c.reference, 
            c.estate, c.city, c.state, c.zip_code, c.telephone, c.extra, c.active'))
        ->from($db->quoteName(self::$cedisTable, 'c'))
        ->where('c.active = 1')
        ->order($db->quoteName('c.names_cedis') . ' ASC');

        $db->setQuery($query);

        $results = $db->loadObjectList();
        return $results;
    }

    public static function getCedis($id){
        $results = array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
        ->select(array('c.id, c.cedis_id, c.names_cedis, c.street, 
            c.ext_number, c.int_number, c.location, c.reference, 
            c.estate, c.city, c.state, c.zip_code, c.telephone, c.extra, c.active'))
        ->from($db->quoteName(self::$cedisTable, 'c'))
        ->where('c.id = ' . $db->Quote($id))
        ->where('c.active = 1')
        ->order($db->quoteName('c.names_cedis') . ' ASC');

        $db->setQuery($query);

        $result = $db->loadObject();

        if (is_null($result)) {
            $result = new stdClass();
            $result->id = '';
            $result->cedis_id = '';
            $result->city = '';
            $result->state = '';
            $result->names_cedis = '';
        }

        return $result;
    }
}