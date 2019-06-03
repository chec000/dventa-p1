<?php
/**
 * @package     Joomla.Front
 * @subpackage  com_cart
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/CartHelper.php';

class CartController extends JControllerLegacy
{
    /**
     * View cart
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
        CartHelper::cart($this->input,$this);
        parent::display();            
    }      

    /**
     * View deleteItem
     * 
     */
    public function deleteItem()
    {             
        CartHelper::delete($this->input,$this);
        parent::display();
    } 

    /**
     * View updateItem
     * 
     */
    public function updateItem()
    {             
        CartHelper::update($this->input,$this);
        parent::display();
    } 

    /**
     * View emptyCart
     * 
     */
    public function emptyCart()
    {             
        CartHelper::emptyCart($this->input,$this);
        parent::display();
    } 

    /**
     * View addCart
     * 
     */
    public function addCart()
    {             
        CartHelper::create($this->input,$this);
        parent::display();
    } 
}