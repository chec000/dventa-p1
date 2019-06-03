<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class catalogViewpuploads extends JViewLegacy
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
          'a.file_name' => JText::_('COM_CATALOG_FILE'),
          'a.uploaded_at' => JText::_('COM_CATALOG_DATE'),
          'a.id' => JText::_('PRODUCTS_ID') 
      );
  }  

    /**
     * 
     */
    public function addTools()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolbarHelper::title(JText::_('COM_CATALOG_PXP_TITLE'), '');

        $canDo = CatalogHelper::getActions();
        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('pupload.add');
        }
        if ($canDo->get('core.delete'))
        {
            JToolbarHelper::deleteList('','puploads.delete');
        }
        JToolbarHelper::cancel('puploads.cancel');
    }        
}