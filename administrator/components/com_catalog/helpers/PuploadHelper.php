<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jimport('joomla.filesystem.file');

class PuploadHelper
{
    
    const TABLE_PRDUCTS_X_ROLES = 'core_products_x_roles';
    
    const TABLE_PRODUCTS = 'core_products';
    
    const  TABLE_USERSGROUPS = '#__usergroups';

    /**
     * 
     * @return type
     */
    public static function setFile()
    {
        $file = JRequest::getVar('jform', null, 'files', 'array'); 
        $data = array(
            'id'=>0,
            'user_id'=>JFactory::getUser()->id,
            'file_name'=>self::moveFile($file),
            'file_type'=>'prols',
            'tags'=>null
        );
        return $data;
    }  
    
    /**
     * 
     * @param type $file
     * @return type
     */
    public static function moveFile($file)
    {
        $hashFile = self::getNameFilehash();
        $uploadPath = JPATH_SITE.'/tmp/com_catalog';
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
                 'rol'=>$value[1],
                 'precio'=>$value[2]
             );
                self::savePrice($item);
            }
        }
    }
    
    /**
     * 
     * @param type $item
     */
    public static function savePrice($item)
    {
        $pxrols = self::getPxrol($item['sku'], $item['rol']);
        $product = self::getProduct($item['sku']);
        if(!isset($pxrols->id)&& isset($product->id)){
            self::insert($item, $product);
        }elseif(isset($product->id)&&isset($pxrols->id)){
            self::update($pxrols->id,$item['precio']);
        }
    }  
    
    /**
     * 
     * @param type $sku
     * @param type $rol
     * @return type
     */
    public static function getPxrol($sku,$rol)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.rol_id', 'a.product_id'))
        ->from($db->quoteName(self::TABLE_PRDUCTS_X_ROLES, 'a'))
        ->join('INNER', $db->quoteName(self::TABLE_PRODUCTS, 'b') . ' ON (' . 
            $db->quoteName('b.id') . ' = ' . 
            $db->quoteName('a.product_id') . ')')
        ->join('INNER', $db->quoteName(self::TABLE_USERSGROUPS, 'c') . ' ON (' . 
            $db->quoteName('c.id') . ' = ' . 
            $db->quoteName('a.rol_id') . ')')                    
        ->where('b.sku = ' . $db->Quote($sku))
        ->andWhere('a.rol_id = ' . $db->Quote($rol));
        $db->setQuery($query);
        return $db->loadObject();        
    } 
    
    /**
     * 
     * @param type $value
     * @param type $key
     * @return type
     */
    public static function getProduct($value,$key='sku')
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.sku'))
        ->from($db->quoteName(self::TABLE_PRODUCTS, 'a'))
        ->where('a.'.$key.' = ' . $db->Quote($value));
        $db->setQuery($query);
        return $db->loadObject();          
    } 
    
    /**
     * 
     * @param type $id
     * @param type $price
     * @return type
     */
    public static function update($id,$price)
    {
     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $fields = array(
        $db->quoteName('price') . ' = ' . $db->quote($price)
    );
     $conditions = array(
        $db->quoteName('id') . ' = ' . $db->quote($id)
    );
     $query->update($db->quoteName(self::TABLE_PRDUCTS_X_ROLES))
     ->set($fields)->where($conditions);
     $db->setQuery($query);
     return $db->execute();        
 } 
 
    /**
     * 
     * @param type $item
     * @param type $product
     */
    public static function insert($item,$product)
    {
        $pxrol = new stdClass();
        $pxrol->rol_id = $item['rol'];
        $pxrol->product_id = $product->id;
        $pxrol->price = $item['precio'];
        try{
            $result = JFactory::getDbo()
            ->insertObject(self::TABLE_PRDUCTS_X_ROLES, $pxrol);                
        } catch (\Exception $ex) {

        }        
    }        
}
