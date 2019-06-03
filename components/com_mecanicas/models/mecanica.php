<?php
defined('_JEXEC') or die;

class MecanicasModelMecanica extends JModelList
{

  public function __construct($config = array())
  {

    if (empty($config['filter_fields']))
    {

      $config['filter_fields'] = array(
              'id','a.id','state','a.state',
              'usergroup', 'a.usergroup',
              'content', 'a.content'
              );
    }

    parent::__construct($config);
  }

  protected function getListQuery()
  {
	$user = JFactory::getUser();
	
	$groups= implode(',',$user->groups);
	
    $db = $this->getDbo();

    $query = $db->getQuery(true)
                ->select('a.id, a.usergroup, a.content, a.state')
                ->from($db->quoteName('#__core_mecanicas').' AS a')
                ->where('(a.state = 1 AND a.usergroup IN ('.$groups.') )');
    return $query;
  }

  /*protected function getUserProfileId()
  {

    $user = JFactory::getUser();
    $db = $this->getDbo();
    $query = $db->getQuery(true)
      ->select('vl.id')
      ->from($db->quoteName('#__users').' AS u')
      ->join('INNER', $db->quoteName('#__user_usergroup_map').' AS ugm ON u.id = ugm.user_id')
      ->join('INNER', $db->quoteName('#__viewlevels').' AS vl ON vl.id = ugm.group_id')
      ->where('(u.id = '.(int) $user->id.')');
    $db->setQuery($query);
    $data= $db->loadObject();

    return $data;

  }*/

}
