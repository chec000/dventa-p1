<?php

defined('_JEXEC') or die;

class CategoryModelHelper {

    protected static $CategoryTable = 'core_product_categories';
    protected static $productCategoryTable = 'core_products_x_categories';

    public static function update($params, $id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('file_name') . ' = ' . $db->quote($params['fileName'])
        );

        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );

        $query->update($db->quoteName(self::$CategoryTable))
            ->set($fields)->where($conditions);

        $db->setQuery($query);

        $db->execute();
    }

    public static function get($id){
        $results = array();

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
                ->select(array('a.id, a.name, a.file_name, a.description , count(a.id) as products'))
                ->from($db->quoteName(self::$CategoryTable, 'a'))
                ->join('INNER', $db->quoteName(self::$productCategoryTable, 'PC') . ' ON (' . 
                    $db->quoteName('PC.category_id') . ' = ' . 
                    $db->quoteName('a.id') . ')')
                ->where('a.id = ' . $db->Quote($id)) 
                ->group($db->quoteName('a.id'));

                $db->setQuery($query);

            $results = $db->loadObjectList();

        return $results[0];
    }
}