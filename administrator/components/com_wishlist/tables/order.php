<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_WISHLIST
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistTableOrder extends JTable
{
    /**
     * 
     * @param type $db
     */
    public function __construct(&$db)
    {
        parent::__construct('#__core_wishlist_orders', 'id', $db);
    }
    
    /**
     * Es usada para preparar los datos inmediatamente antes de ser 
     * guardados en la BD
     * 
     * @param type $array
     * @param type $ignore
     * @return type
     */
    public function bind($array, $ignore = '')
    {
        return parent::bind($array, $ignore);
    }
    
    /**
     * Almacena los datos en el submit del formulario
     * 
     * @param type $updateNulls
     * @return type
     */
    public function store($updateNulls = false)
    {
        return parent::store($updateNulls);
    }
        
     
}