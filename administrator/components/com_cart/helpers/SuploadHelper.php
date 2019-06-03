<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jimport('joomla.filesystem.file');

class SuploadHelper
{

    const TABLE_PRODUCTS_STOCK = '#__core_products_stock';
    const TABLE_PRODUCTS = 'core_products';

    /**
     * 
     * @return type
     */
    public static function setFile()
    {
        $file = JRequest::getVar('jform', null, 'files', 'array');
        if ($file['name']['file_name'] != '') {
            $description = JRequest::getVar('jform',null,'')['description'];
            $data = array(
                'id'=>0,
                'user_id'=>JFactory::getUser()->id,
                'description'=>$description,
                'file_name'=>self::moveFile($file),
                'file_type'=>'stock.upload'
            );
            return $data;
        } 
        return false;
    }  
    
    /**
     * 
     * @param type $file
     * @return type
     */
    public static function moveFile($file)
    {
        $hashFile = self::getNameFilehash();
        $uploadPath = JPATH_SITE.'/tmp/com_cart';
        if(!is_dir($uploadPath)){
            mkdir($uploadPath);
        }
        $newFile = $uploadPath .'/'. $hashFile;
        JFile::upload($file['tmp_name']['file_name'], $newFile);
        self::import($newFile);
        return $hashFile;
    }     
    
    /**
     * 
     * @param type $ext
     * @return type
     */
    public static function getNameFilehash($ext='csv'){
        return hash('sha1', uniqid(time(),true)).'.'.$ext;
    } 
    
    /**
     * 
     * @param type $filepath
     */
    public static function import($filepath)
    {
        $csv = new SplFileObject($filepath);
        $csv->setFlags(SplFileObject::READ_CSV | 
            SplFileObject::READ_AHEAD | 
            SplFileObject::SKIP_EMPTY | 
            SplFileObject::DROP_NEW_LINE);
        $csv->setCsvControl(',','"','\\');
        foreach ($csv as $key=>$value){
            if($key>0){ 
                $item = array(                   
                 'sku'=>$value[0],
                 'stock'=>$value[1]
             );
                self::saveStock($item);
            }
        }
    }
    
    /**
     * 
     * @param type $item
     */
    public static function saveStock($item)
    {
        $product = self::getProduct($item['sku']);
        if(isset($product->id) && isset($item['stock'])){
            $stock = self::getStock($product->id);
            if (isset($stock->id))
                self::updateStock($product->id, $item['stock']);
            else
                self::insertStock($product->id, $item['stock']);
        }
    }  
    
    /**
     * 
     * @param type $sku
     * @return type
     */
    public static function getProduct($sku)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.sku'))
        ->from($db->quoteName(self::TABLE_PRODUCTS, 'a'))
        ->where('a.enabled = 1')
        ->where('a.sku = ' . $db->Quote($sku));
        $db->setQuery($query);
        return $db->loadObject();          
    } 

    /**
     * 
     * @return type
     */
    public static function getProducts()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.sku', 'IFNULL(s.stock,0) as stock'))
        ->from($db->quoteName(self::TABLE_PRODUCTS, 'a'))
        ->join('LEFT', $db->quoteName(self::TABLE_PRODUCTS_STOCK, 's') . ' ON (' . 
            $db->quoteName('s.product_id') . ' = ' . 
            $db->quoteName('a.id') . ')')
        ->where('a.enabled = 1')
        ->order('a.id');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;          
    } 

    /**
     * 
     * @param type $product_id
     * @return type
     */
    public static function getStock($product_id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.product_id', 'a.stock'))
        ->from($db->quoteName(self::TABLE_PRODUCTS_STOCK, 'a'))
        ->where('a.product_id = ' . $db->Quote($product_id));
        $db->setQuery($query);
        return $db->loadObject();          
    } 
    
    /**
     * 
     * @param type $product_id
     * @param type $stock
     */
    public static function insertStock($product_id, $stock)
    {
        $stockClass = new stdClass();
        $stockClass->product_id = $product_id;
        $stockClass->stock = $stock;
        try{
            $result = JFactory::getDbo()
            ->insertObject(self::TABLE_PRODUCTS_STOCK, $stockClass);                
        } catch (\Exception $ex) {
        }      
    }   

    /**
     * 
     * @param type $product_id
     * @param type $stock
     */
    public static function updateStock($product_id, $stock)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $fields = array(
            $db->quoteName('stock') . ' = ' . $db->quote($stock)
        );

        $conditions = array(
            $db->quoteName('product_id') . ' = ' . $db->quote($product_id)
        );

        $query->update($db->quoteName(self::TABLE_PRODUCTS_STOCK))
        ->set($fields)->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }  
}