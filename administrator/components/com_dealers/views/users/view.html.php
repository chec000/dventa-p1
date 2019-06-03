<?php

defined('_JEXEC') or die;

// Nombre del Componente + View + Nombre de la vista
class DealersViewUsers extends JViewLegacy
{

    //Para almacenar los datos devueltos por el modelo
    protected $items;
    //Almacenará la columna que estamos ordenando y la dirección del ordenamiento
    protected $state;

    protected $pagination;

    //Función que se ejecuta por default si no se esta requiriendo otra vista
    public function display($tpl = null)
    {

      //Obtiene los datos del modelo {models/ModelName.php}
      $this->items = $this->get('Items');
      $this->state = $this->get('State');
      $this->pagination = $this->get('Pagination');

      //Desplegar submenu
      DealersHelper::addSubmenu('users');

      //En caso de que algo salga mal con la query a la BD
      if (count($errors = $this->get('Errors')))
      {
        JError::raiseError(500, implode("\n", $errors));
        return false;
      }

      $this->addToolbar();
      //Agregar el sideBar
      $this->sidebar = JHtmlSidebar::render();

      parent::display($tpl);

    }

    //Generar el toolbar verificando los permisos que tiene el usuario
    protected function addToolbar()
    {

      $state = $this->get('State');

      //Verificar permisos usando el helper
      $canDo = DealersHelper::getActions();
      //($state->get('filter.category_id'));
      $user = JFactory::getUser();

      //Instanciar la toolbar para empezar a añadirle titulos y botones
      $bar = JToolBar::getInstance('toolbar');

      //Titlo de la vista
      JToolbarHelper::title(JText::_('COM_DEALERS_MANAGER_USERS'), '');
      if ($canDo->get('core.create'))
      {
        JToolbarHelper::addNew('user.add');
      }

      if ($canDo->get('core.edit'))
      {
        JToolbarHelper::editList('user.edit');
      }

      $state = $this->get('State');

      if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
      {
        JToolbarHelper::deleteList('', 'users.delete', 'JTOOLBAR_EMPTY_TRASH');
      } elseif ($canDo->get('core.edit.state'))
      {
        JToolbarHelper::trash('users.trash');
      }

      if ($canDo->get('core.admin'))
      {
        JToolbarHelper::preferences('com_dealers');
      }

      //Filtro lateral de búsqueda por estatus
      JHtmlSidebar::setAction('index.php?option=com_dealers&view=users');
      JHtmlSidebar::addFilter( JText::_('JOPTION_SELECT_PUBLISHED'),'filter_state',JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'),'value', 'text', $this->state->get('filter.state'), true));
    }

    protected function getSortFields()
    {
      return array('a.ordering' => JText::_('JGRID_HEADING_ORDERING'),'a.state' => JText::_('JSTATUS'),'a.id' => JText::_('JGRID_HEADING_ID') );
    }
}
