<?php
defined('_JEXEC') or die;

class DealersHelper
{
    public static function getActions($categoryId = 0)
    {

      $user = JFactory::getUser();
      $result = new JObject;

      $assetName = 'com_dealers';
      $level = 'component';

      $actions = JAccess::getActions('com_dealers', $level);

      foreach ($actions as $action)
      {
        $result->set($action->name, $user->authorise($action->name,$assetName));
      }

      return $result;
    }

    public static function addSubmenu($vName = 'dealer')
    {
      JHtmlSidebar::addEntry( JText::_('COM_DEALERS_SUBMENU_DEALERS'),'index.php?option=com_dealers&view=dealers', $vName == 'dealers' );
      JHtmlSidebar::addEntry( JText::_('COM_DEALERS_SUBMENU_USERS-DEALER'),'index.php?option=com_dealers&view=users', $vName == 'users' );
    }

}
