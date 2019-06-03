<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class WishlistControllerOrder extends JControllerForm{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getModel($name = 'order', $prefix = 'wishlistModel', 
		$config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function guardar()
	{
		$cform = JRequest::getVar('jform',  0, '');
		$model = $this->getModel('order');
		$model->guardar($cform);
		$this->setRedirect(JRoute::_(
			'index.php?option=com_wishlist&view=orders', false));
	}
}