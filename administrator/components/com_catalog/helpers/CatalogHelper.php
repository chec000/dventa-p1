<?php
/**
 * 
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
class CatalogHelper
{
 const CORE_MOTIVALE_REQUEST = 'core_motivale_request';

 const SYNC_STATUS_ADD = 0;

 const SYNC_STATUS_NEW = 1;

 const SYNC_STATUS_PROCESS = 2;

 const SYNC_STATUS_DONE = 3;

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function products(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'products');
        $_input->set('view', $vName);
        $view = $_this->getView('products','html');
    }
    
    /**
     * Elementos de Helix
     * 
     */
    public static function addSubmenu()
    {
        JToolbarHelper::title(JText::_('COM_CATALOG'), '');
        JHtmlSidebar::addEntry(JText::_('PRODUCTS_MAIN_TITLE'),
            'index.php?option=com_catalog&view=products', 'products' );
        JHtmlSidebar::addEntry(JText::_('CPRODUCTS_MAIN_TITLE'),
            'index.php?option=com_catalog&view=cproducts', 'cproducts' );
        JHtmlSidebar::addEntry(JText::_('PRODUCTS_ROLES'),
            'index.php?option=com_catalog&view=pxrols', 'pxrols');         
        JHtmlSidebar::addEntry(JText::_('CATEGORIES_MAIN_TITLE'),
            'index.php?option=com_catalog&view=categories', 'categories');
        JHtmlSidebar::addEntry(JText::_('CATEGORIES_ROLES'),
            'index.php?option=com_catalog&view=cxrols', 'cxrols'); 

        $canDo = self::getActions();      
        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_catalog');
        }  
    }

    public static function getActions()
    {
        $user   = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_catalog';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
    
    /**
     * 
     * @return type
     */
    public static function setSync()
    {      
        $sync = (int)JRequest::getVar('sync');
        $isSync = $sync===0?self::SYNC_STATUS_ADD:$sync;        
        if($isSync=== self::SYNC_STATUS_NEW){
            self::addSync();
        }
        $isSync = self::isSync();
        self::queueTask();
        return $isSync;
    }
    
    /**
     * 
     */
    public static function addSync()
    {
        $user = JFactory::getUser()->id;
        if ($user > 0) {
            $sync = new stdClass();
            $sync->user_id = $user;
            $sync->file_name = bin2hex(random_bytes(4)).'.json';
            $sync->action = 'new';
            JFactory::getDbo()
            ->insertObject(self::CORE_MOTIVALE_REQUEST, $sync);
        }
    }   
    
    /**
     * 
     * @return type
     */
    public static function isSync()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('b.id', 'b.user_id', 'b.request_date','b.action'))
        ->from($db->quoteName(self::CORE_MOTIVALE_REQUEST, 'b'))
        ->where('b.action = ' . $db->Quote('new'))
        ->order($db->quoteName('b.id') . ' ASC');
        $db->setQuery($query);   
        $results = $db->loadObjectList();
        return count($results)===0?self::SYNC_STATUS_ADD:self::SYNC_STATUS_PROCESS;  
    } 
    /**
     * 
     */
    public static function queueTask()
    {
        $path=  realpath((__DIR__).'/../../../../').'/libraries/jcli/';
        $filename = $path.'bin/app';
        if(file_exists($filename.'.php')){
            $oldldpath = getenv('LD_LIBRARY_PATH');
            putenv("LD_LIBRARY_PATH=");
            $command = "php {$filename}.php motivale start > /dev/null &";
            $output = system($command);
            putenv("LD_LIBRARY_PATH=$oldldpath");
        }      
    }

    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function category(&$_input,&$_this)
    {
        $_this->category_id = JRequest::getVar('id');
        $vName = $_input->get('view', 'category');
        $_input->set('view', $vName);
        $view = $_this->getView('category','html');
        $view->category_id = $_this->category_id;
        $view->update_data = $_input->getArray();
    } 
    
    public static function getIdProductXPrfil($productId)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
        ->select(array('r.id as productid'))
        ->from($db->quoteName('core_products_x_roles', 'r'))
        ->join('INNER', $db->quoteName('core_products', 'p') . ' ON (' . 
            $db->quoteName('p.id') . ' = ' . 
            $db->quoteName('r.product_id') . ')')
        ->where('p.id = ' . $db->Quote($productId));
        $db->setQuery($query);
        $result = $db->loadResult();
        return count($result)>0?(int)$result:0;
    }  
}
