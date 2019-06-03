<?php
defined('_JEXEC') or die;

class DealersController extends JControllerLegacy
{
//Requerido si nuestra vista por default difiere del nombre del controlador {folios!=folio}
  //protected $default_view = 'dealers';

//función que se ejecuta por default cuando no se esta solicitando una tarea en especifico.
  public function display($cachable = false, $urlparams = false)
  {
    //Incluimos código de nuestro helper
    require_once JPATH_COMPONENT.'/helpers/dealers.php';

    //Obtenemos las variables desde la url {index.php?option=com_componentName&view=ViewName&layout=edit}
    $view = $this->input->get('view', 'dealers');
    $layout = $this->input->get('layout', 'default');
    $id = $this->input->getInt('id');

    //Proteje al componente de alguien que intente editar directamente.
    if ($view == 'dealer' && $layout == 'edit' && !$this->checkEditId('com_dealers.edit.dealer', $id))
    {
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_dealers&view=dealers', false));
      return false;
    }

    parent::display();
    return $this;
  }

}
