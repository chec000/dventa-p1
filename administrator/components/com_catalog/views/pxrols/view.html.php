<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class catalogViewpxrols extends JViewLegacy
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
          'b.title' => JText::_('PRODUCTS_TITLE'),
          'a.price' => JText::_('PRODUCTS_PRICE'),
          'a.id' => JText::_('PRODUCTS_ID') 
      );
  }  

    /**
     * 
     */
    public function addTools()
    {
        JToolbarHelper::title(JText::_('COM_CATALOG_PXP_TITLE'), '');
        $canDo = CatalogHelper::getActions();

        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('pxrol.add');
            JToolbarHelper::custom('puploads.lista','upload.png','',JText::_('COM_CATALOG_UPLOADCSV'),false);
            JToolbarHelper::custom('pxrols.template','download.png','','Template csv',false);
        }

        if ($canDo->get('core.delete'))
        {
            JToolbarHelper::deleteList('','pxrols.delete');
        }
    }        
}