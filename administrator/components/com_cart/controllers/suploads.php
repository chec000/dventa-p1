<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CART
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/SuploadHelper.php';

class CartControllerSuploads extends JControllerAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getModel($name = 'supload', $prefix = 'cartModel', 
		$config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function cancel()
	{
		$this->setRedirect(JRoute::_(
			'index.php?option=com_cart', false));        
	}


	public function template()
	{
		$productos = SuploadHelper::getProducts();
		$template = 'sku,stock' . "\r\n";
		foreach ($productos as $producto) {
			$template .= $producto->sku . ',' . $producto->stock . "\r\n";
		}
		ob_end_clean();
		$app = JFactory::getApplication();
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=stock_template.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $template;
		$app->close();
	}
}