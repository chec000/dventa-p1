<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class catalogViewcategories extends JViewLegacy
{
    /**
     *
     * @var type 
     */
    protected $items;

    /**
     *
     * @var type 
     */
    protected $state;

    /**
     *
     * @var type 
     */
    protected $pagination;
    
    /**
     * Accion Productos
     * 
     * @param type $tpl
     */
    function display($tpl = null)
    {

        $this->items = $this->get('Items');
        $this->state = $this->get('State');
        $this->pagination = $this->get('Pagination'); 
        $this->addToolbar();          
        CatalogHelper::addSubmenu();
        self::addElements();
        $this->sidebar = JHtmlSidebar::render();            
        parent::display();
    }
    
    protected function addToolbar()
    {
        $canDo = CatalogHelper::getActions();
        if ($canDo->get('core.create'))
        {
            JToolbarHelper::save('product.add',JText::_('PRODUCTS_MAIN_UPDATE_TITLE')); 
        }
    }
    
    /**
     * 
     * @return type
     */
    protected function getSortFields()
    {
      return array(
          'a.name' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_NAME'),
          'a.description' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_DESCRIPTION'),
          'a.id' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_ID') 
      );
  } 

  public static function addElements()
  {
    JToolbarHelper::title(JText::_('VIEW_CATEGORIES_ADDELEMENTS_TITLE'), '');        
}     
}