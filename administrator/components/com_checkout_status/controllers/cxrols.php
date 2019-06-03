<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout_status
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class Checkout_StatusControllerCxrols extends JControllerAdmin
{
	public function getModel($name = 'Cxrol', $prefix = 'Checkout_StatusModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}