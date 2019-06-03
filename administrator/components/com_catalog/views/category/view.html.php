<?php
defined('_JEXEC') or die('Restricted access');

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/CategoryModelHelper.php';

class catalogViewcategory extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->update_status = null;

        $update_data = isset($this->update_data['fileName'])?$this->update_data:null;

        if (!is_null($update_data)) {
          $this->update_status = $this->updateCategory($update_data, $this->category_id);
        }

        $this->category = $this->getCategory($this->category_id);

        $this->addToolbar();
        parent::display();
    }

    public function getCategory($category_id)
    {
        $category = CategoryModelHelper::get($category_id);

        return $category;    
    }

    public function updateCategory($params, $id)
    {
        $status = CategoryModelHelper::update($params, $id);

        return $status;
    }

    protected function addToolbar()
    {

      JFactory::getApplication()->input->set('hidemainmenu', true);
      JToolbarHelper::title(JText::_('VIEW_CATEGORY_ADDTOOLBAR_TITLE'), '');

      $canDo = CatalogHelper::getActions();
      if ($canDo->get('core.edit'))
      {
        JToolbarHelper::apply('category');
      }

      JToolbarHelper::cancel('cancelCategory');

    }    
}