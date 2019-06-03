<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Core_configs
 * @author     Adventa <>
 * @copyright  Adventa (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Core_configs controller class.
 *
 * @since  1.6
 */
class Core_configsControllerCore_configs extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'configs';
		parent::__construct();
	}
}
