<?php
defined('_JEXEC') or die;

// Nomenclatura de la clase Nombre del componente + View + Nombre de la vista
class MecanicasViewMecanica extends JViewLegacy
{

    protected $items;

    public function display($tpl = null)
    {

      $this->items = $this->get('Items');

      if (count($errors = $this->get('Errors')))
      {
        JError::raiseError(500, implode("\n", $errors));
        return false;
      }

      parent::display($tpl);
    }
}
