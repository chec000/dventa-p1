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

/**
 * Class Core_configsController
 *
 * @since  1.6
 */
class Core_configsController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return   JController This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view = JFactory::getApplication()->input->getCmd('view', 'configs');
		JFactory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
