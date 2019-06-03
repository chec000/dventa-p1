<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class catalogTablecxrol extends JTable
{
    /**
     * 
     * @param type $db
     */
    public function __construct(&$db)
    {
        parent::__construct('core_product_categories_x_roles', 'id', $db);
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


