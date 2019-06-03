<?php
defined('_JEXEC') or die;

class WishlistModelUser extends JModelLegacy
{
  protected $profileTable = '#__user_profiles';

  public function getProfileByKey($id,$key){
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    $query->select(array('p.*'));
    $query->from($db->quoteName($this->profileTable, 'p'));
    $query->where($db->quoteName('p.user_id') . ' = '. $db->quote($id).' AND '.$db->quoteName('p.profile_key') . ' = '. $db->quote($key));
    $db->setQuery($query);
    $result = $db->loadObjectList();
    if($result!=null){
      return $result[0];      
    } 
  }
}