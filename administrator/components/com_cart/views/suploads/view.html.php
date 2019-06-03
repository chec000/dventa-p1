<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CART
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class CartViewSuploads extends JViewLegacy
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
          'a.id' => JText::_('COM_CART_SUPLOADS_ID'),
          'u.username' => JText::_('COM_CART_SUPLOADS_USER'),
          'a.description' => JText::_('COM_CART_SUPLOADS_DESCRIPTION'),
          'a.file_name' => JText::_('COM_CART_SUPLOADS_FILENAME'),
          'a.uploaded_at' => JText::_('COM_CART_SUPLOADS_UPLOADDATE')
      );
  }
    /**
     * 
     */
    public function addTools()
    {
        JToolbarHelper::title(JText::_('COM_CART_TITLE_CONFIGS'), '');
        $canDo = CartHelper::getActions();
        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('supload.add');
            JToolbarHelper::custom('suploads.template','download.png','','COM_CART_TEMPLATE_CSV',false);
        }
        if ($canDo->get('core.delete'))
        {
            JToolbarHelper::deleteList('','suploads.delete');
        }
        JToolbarHelper::cancel('suploads.cancel');
    }        
}
