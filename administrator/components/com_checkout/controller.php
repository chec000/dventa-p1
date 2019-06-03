<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/OrderHelper.php';

class CheckoutController extends JControllerLegacy
{
    /**
     * View products
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
        $vName = $this->input->get('view', 'Orders');
        $this->input->set('view', $vName);
        $view = $this->getView('Orders','html');
       parent::display();           
    }           
}