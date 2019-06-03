<?php
/**
 * @version    1.0.0
 * @package    COM_CART
 * @author     Zitdev <>
 * @copyright  Zitdev (C) 2017. All rights reserved.
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

/**
 * 
 *
 * @since  1.6
 */
class CartControllerCart extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'carts';
		parent::__construct();
	}
}
