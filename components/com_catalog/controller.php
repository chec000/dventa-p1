<?php
/**
 * @package     Joomla.Front
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/ProductHelper.php';

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
        $view = $this->input->get('view', 'Catalog');
        ProductHelper::products($this->input,$this);  
    }
    
    /**
     * View product
     * 
     */
    public function product()
    {
        ProductHelper::product($this->input,$this);
    }   

    /**
     * View like
     * 
     */
    public function like()
    {
        ProductHelper::like($this->input,$this);
    }    

    /**
     * View dislike
     * 
     */
    public function dislike()
    {
        ProductHelper::dislike($this->input,$this);
    }            
}