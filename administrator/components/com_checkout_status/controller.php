<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CHECKOUT_STATUS
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/Checkout_Status.php';

class Checkout_StatusController extends JControllerLegacy
{
    /**
     * View products
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
        Checkout_StatusHelper::checkout($this->input,$this);
        parent::display();            
    }

    public function closeCheckout($cachable = false, $urlparams = array())
    {
        Checkout_StatusHelper::closeCheckout($this->input,$this);
        parent::display();            
    }

    public function openCheckout($cachable = false, $urlparams = array())
    {
        Checkout_StatusHelper::openCheckout($this->input,$this);
        parent::display();            
    }
}