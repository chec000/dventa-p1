<?php
defined('_JEXEC') or die;

class com_mecanicasInstallerScript
{

    function install($parent)
    {
      $parent->getParent()->setRedirectURL('index.php?option=com_mecanicas');
    }

    function uninstall($parent)
    {
      echo '<p>' . JText::_('COM_MECANICAS_UNINSTALL_TEXT') . '</p>';
    }

    function update($parent)
    {
      echo '<p>' . JText::_('COM_MECANICAS_UPDATE_TEXT') . '</p>';
    }

    //Se ejecuta antes de que el componente se instale
    function preflight($type, $parent)
    {

    }

    //Se ejecuta después de que el componente se instala
    function postflight($type, $parent)
    {

    }

}
