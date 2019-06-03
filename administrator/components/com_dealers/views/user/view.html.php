<?php
defined('_JEXEC') or die;

//Nomenclatura = Componente + View + Nombre de la vista
class DealersViewUser extends JViewLegacy
{

    //Para almacenar los datos del modelo
    protected $item;
    //Para construir el formulario
    protected $form;

    //Se ejecuta por default si no se esta solicitando otra vista
    public function display($tpl = null)
    {
      $this->item = $this->get('Item');
      $this->form = $this->get('Form');

      /*Checar errores, estos pueden ocurrir si alguno de los campos no se encuentran
        podría suceder si se actualizó el componente y el script no generó los nuevos campos
      */
      if (count($errors = $this->get('Errors')))
      {
        JError::raiseError(500, implode("\n", $errors));
        return false;
      }

      $this->addToolbar();
      parent::display($tpl);
    }

    protected function addToolbar()
    {
      $user = JFactory::getUser();
      $userId = $user->get('id');
      $isNew = ($this->item->id == 0);
      $canDo = DealersHelper::getActions();

      //Ocultar el menu principal para no ver los enlaces a otras vistas
      JFactory::getApplication()->input->set('hidemainmenu', true);
      JToolbarHelper::title(JText::_('COM_DEALERS_MANAGER_USERS'), '');

      if ($canDo->get('core.edit'))
      {
        JToolbarHelper::apply('user.apply');
        JToolbarHelper::save('user.save');
        JToolbarHelper::save2new('user.save2new');
      }

      // If an existing item, can save to a copy.
      if (!$isNew)
      {
        JToolbarHelper::save2copy('user.save2copy');
      }

      //Si se esta creando un registro nuevo se muestra el botón de cancelar, si se esta editando se muestra cerrar
      if (empty($this->item->id))
      {
        JToolbarHelper::cancel('user.cancel');
      }
      else
      {
        JToolbarHelper::cancel('user.cancel', 'JTOOLBAR_CLOSE');
      }
    }

}
