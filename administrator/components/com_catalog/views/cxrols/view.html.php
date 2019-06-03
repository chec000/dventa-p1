<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class catalogViewcxrols extends JViewLegacy
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
        CatalogHelper::addSubmenu();
        $this->sidebar = JHtmlSidebar::render();
        $this->addTools();
        parent::display();
    }
    
    /**
     * 
     * @return type
     */
    protected function getSortFields()
    {
      return array(
          'b.name' => JText::_('CATALOGS_CATEGORY'),
          'b.description' => JText::_('CATALOGS_DESCRIPTION'),
          'a.id' => JText::_('VIEW_CATEGORIES_GETSORTFIELD_ID') 
      );
  }  

    /**
     * 
     */
    public function addTools()
    {
        JToolbarHelper::title(JText::_('VIEW_CATEGORIES_DISPLAY_SAVE'), '');

        $canDo = CatalogHelper::getActions();

        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('cxrol.add');
            JToolbarHelper::custom('cuploads.lista','upload.png','',JText::_('COM_CATALOG_UPLOADCSV'),false);
            JToolbarHelper::custom('cxrols.template','download.png','','Template csv',false);
        }

        if ($canDo->get('core.delete'))
        {
            JToolbarHelper::deleteList('','cxrols.delete');
        }
    }        
}