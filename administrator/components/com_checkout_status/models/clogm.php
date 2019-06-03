<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout_status
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class Checkout_StatusModelClogm extends JModelLegacy
{
  protected $logsTable = '#__core_checkout_log';

  public function createLog($params){
    $db = $this->getDbo();
    $id = 0;
    $user = JFactory::getUser()->id;
    $log = new stdClass();
    $log->user_id = $user;
    $log->action = $params['action'];
    $log->type = $params['type'];
    $log->applied_at = $params['applied_at'];

    $db->insertObject($this->logsTable, $log);
    $id = $db->insertid();
    return $id;
  }
}