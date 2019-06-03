<?php
defined('_JEXEC') or die;

class MecanicasController extends JControllerLegacy
{
//Requerido si nuestra vista por default difiere del nombre del controlador
  //protected $default_view = 'vistapordefault';

//función que se ejecuta por default cuando no se esta solicitando una tarea en especifico.
  public function display($cachable = false, $urlparams = false)
  {
    //Incluimos código de nuestro helper
    require_once JPATH_COMPONENT.'/helpers/mecanicas.php';

    //Obtenemos las variables desde la url {index.php?option=com_componentName&view=ViewName&layout=edit}
    $view = $this->input->get('view', 'mecanicas');
    $layout = $this->input->get('layout', 'default');
    $id = $this->input->getInt('id');

    //Proteje al componente de alguien que intente editar directamente.
    if ($view == 'mecanica' && $layout == 'edit' && !$this->checkEditId('com_mecanicas.edit.mecanica', $id))
    {
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_mecanicas&view=mecanicas', false));
      return false;
    }

    parent::display();
    return $this;
  }

}
