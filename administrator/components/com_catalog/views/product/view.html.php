<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class catalogViewproduct extends JViewLegacy
{
    /**
     * Accion Productos
     * 
     * @param type $tpl
     */
    public function display($tpl = null)
    {     
        if (!JFactory::getUser()->authorise('core.create', 'com_catalog'))
        {
            throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
        }

        self::addElements();        
        $this->isSync = CatalogHelper::setSync();
        parent::display();
    }  

    /**
     * 
     */
    public static function addElements()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolbarHelper::title(JText::_('PRODUCTS_MAIN_UPDATE_TITLE'), '');        
    }        
}