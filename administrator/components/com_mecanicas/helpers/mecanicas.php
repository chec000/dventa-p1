<?php
defined('_JEXEC') or die;

class MecanicasHelper
{
    public static function getActions($categoryId = 0)
    {

      $user = JFactory::getUser();
      $result = new JObject;

      $assetName = 'com_mecanicas';
      $level = 'component';

      $actions = JAccess::getActions('com_mecanicas', $level);

      foreach ($actions as $action)
      {
        $result->set($action->name, $user->authorise($action->name,$assetName));
      }

      return $result;
    }

    public static function addSubmenu($vName = 'mecanicas')
    {
      JHtmlSidebar::addEntry( JText::_('COM_MECANICAS_SUBMENU_MECANICAS'),'index.php?option=com_mecanicas&view=mecanicas', $vName == 'mecanicas' );
    }

}
