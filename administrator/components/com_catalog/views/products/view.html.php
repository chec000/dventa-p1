<?php
/**
  * @package     Joomla.Administrator
  * @subpackage  com_catalog
  *
  * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
  * @license     GNU General Public License version 2 or later; see LICENSE.txt
  */

defined('_JEXEC') or die('Restricted access');

class catalogViewproducts extends JViewLegacy
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
      $this->sidebar = JHtmlSidebar::render();   
      parent::display();
    }

    protected function addToolbar()
    {
      $canDo = CatalogHelper::getActions();
      if ($canDo->get('core.create'))
      {
        JToolbarHelper::save('product.add', JText::_('PRODUCTS_MAIN_UPDATE_TITLE')); 
      }
    }

    /**
     * 
     * @return type
     */
    protected function getSortFields()
    {
      return array(
        'a.title' => JText::_('PRODUCTS_TITLE'),
        'a.price' => JText::_('PRODUCTS_PRICE'),
        'a.id' => JText::_('PRODUCTS_ID'),
        'a.sku' => JText::_('PRODUCTS_SKU'),
        'a.description' => JText::_('PRODUCTS_DESCRIPTION'),
        'a.file_name' => JText::_('PRODUCTS_IMAGE'),
        'likeF' => JText::_('PRODUCTS_LIKE'),
        'dislikeF' => JText::_('PRODUCTS_DISLIKE')
      );
    }         
  }