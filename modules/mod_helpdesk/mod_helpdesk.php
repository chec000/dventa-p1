<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$component_id = modHelpDeskHelper::getComponentId();
require JModuleHelper::getLayoutPath('mod_helpdesk');