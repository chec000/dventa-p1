<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
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
require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/CatalogHelper.php';

class CatalogController extends JControllerLegacy
{
    /**
     * View products
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
        CatalogHelper::products($this->input,$this);
        parent::display();            
    }
    
    public function cancelCategory()
    {
        $this->setRedirect(
                JRoute::_('index.php?option=com_catalog&view=categories', false));
    } 

    /**
     * View category
     * 
     */
    public function category()
    {
        CatalogHelper::category($this->input,$this);
        parent::display();
    } 
    
}

