<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jimport('joomla.filesystem.file');

class CuploadHelper
{
    
    const TABLE_CATEGORY_X_ROLES = 'core_product_categories_x_roles';
    
    const TABLE_CATEGORY = 'core_product_categories';
    
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
            'file_type'=>'crols',
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
                 'cat_id'=>$value[0],
                 'rol'=>$value[1]
             );
                self::saveCategory($item);
            }
        }
    }
    
    /**
     * 
     * @param type $item
     */
    public static function saveCategory($item)
    {
        $cxrols = self::getCxrol($item['cat_id'], $item['rol']);
        $category = self::getCategory($item['cat_id']);
        if(!isset($cxrols->id)&& isset($category->id)){
            self::insert($item, $category);
        }
    }  
    
    /**
     * 
     * @param type $sku
     * @param type $rol
     * @return type
     */
    public static function getCxrol($catId,$rol)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.rol_id', 'a.category_id'))
        ->from($db->quoteName(self::TABLE_CATEGORY_X_ROLES, 'a'))
        ->join('INNER', $db->quoteName(self::TABLE_CATEGORY, 'b') . ' ON (' . 
            $db->quoteName('b.id') . ' = ' . 
            $db->quoteName('a.category_id') . ')')
        ->join('INNER', $db->quoteName(self::TABLE_USERSGROUPS, 'c') . ' ON (' . 
            $db->quoteName('c.id') . ' = ' . 
            $db->quoteName('a.rol_id') . ')')                    
        ->where('b.id = ' . $db->Quote($catId))
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
    public static function getCategory($value,$key='id')
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('a.id', 'a.name'))
        ->from($db->quoteName(self::TABLE_CATEGORY, 'a'))
        ->where('a.'.$key.' = ' . $db->Quote($value));
        $db->setQuery($query);
        return $db->loadObject();          
    } 
    
    /**
     * 
     * @param type $item
     * @param type $product
     */
    public static function insert($item,$category)
    {
        $cxrol = new stdClass();
        $cxrol->rol_id = $item['rol'];
        $cxrol->category_id = $category->id;
        try{
            $result = JFactory::getDbo()
            ->insertObject(self::TABLE_CATEGORY_X_ROLES, $cxrol);                
        } catch (\Exception $ex) {

        }        
    }        
}
