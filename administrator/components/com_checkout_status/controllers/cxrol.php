<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout_status
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class Checkout_StatusControllerCxrol extends JControllerForm{

	public function getModel($name = 'Cxrol', $prefix = 'Checkout_StatusModel', 
		$config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function guardar()
	{
		$cform = JRequest::getVar('jform',  0, '');
		$model = $this->getModel('Cxrol');
		$model->guardar($cform);
		$this->setRedirect(JRoute::_(
			'index.php?option=com_checkout_status&view=cxrols', false));
	}
}