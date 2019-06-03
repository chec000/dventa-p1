<?php
defined('_JEXEC') or die;

class CheckoutModelUser extends JModelLegacy
{
	protected static $profileTable = '#__user_profiles';
	protected static $userInfoTable = '#__core_user_info';

	public static function getProfileByKey($id,$key){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select(array('p.*'));
		$query->from($db->quoteName(self::$profileTable, 'p'));
		$query->where($db->quoteName('p.user_id') . ' = '. $db->quote($id).' AND '.$db->quoteName('p.profile_key') . ' = '. $db->quote($key));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if($result!=null){
			return $result[0];      
		} 
	}

	public static function getProfileInfo($user){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select(array('i.*'));
		$query->from($db->quoteName(self::$userInfoTable, 'i'));
		$query->where($db->quoteName('i.user_id') . ' = '. $db->quote($user));

		$db->setQuery($query);
		return $db->loadObject();
	}
}