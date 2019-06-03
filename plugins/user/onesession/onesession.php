<?php
/**
 * @copyright Copyright (c) 2017 onesession. All rights reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * user - onesession Plugin
 *
 * @package   Joomla.Plugin
 * @subpakage onesession.onesession
 */
class plguseronesession extends JPlugin {

  /**
   * Constructor.
   *
   * @param   $subject
   * @param array $config
   */
  function __construct(&$subject, $config = array()) {
    // call parent constructor
    parent::__construct($subject, $config);
  }

   public function onUserAfterLogin($options)
    {
      
        $user_id = $options['user']->id;
    
        $session_id = JFactory::getSession()->getId();

        $this->getDeleteSessions($user_id, $session_id);
    
        
    }
  
  private function getDeleteSessions($user_id,$session_id){
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    // delete all custom keys for user 1001.
    $conditions = array(
        $db->quoteName('userid') . ' = ' . $db->quote($user_id), 
        $db->quoteName('session_id') . ' != ' . $db->quote($session_id)
    );

    $query->delete($db->quoteName('#__session'));
    $query->where($conditions);

    $db->setQuery($query);

    $result = $db->execute();
  }

  
}