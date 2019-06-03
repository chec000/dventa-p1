<?php
/**
 * @package     Joomla.Front
 * @subpackage  com_wishlist
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class WishlistController extends JControllerLegacy
{
    /**
     * View checkout
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
     WishlistHelper::wishlist($this->input,$this);
 }

    /**
     * task addList
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function addList()
    {
        WishlistHelper::addList($this->input,$this);
    }

    /**
     * task deleteList
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function deleteList()
    {
        WishlistHelper::deleteList($this->input,$this);
    }

    /**
     * task checkout
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function checkout()
    {
        $checkoutStatus = WishlistHelper::getCheckoutState();
        if ($checkoutStatus) {
            $survey = WishlistHelper::getComponentParams('com_catalog','survey');
            $showConfirm = self::showConfirm($survey);
            if($showConfirm)
                WishlistHelper::confirm($this->input,$this);
            else
                WishlistHelper::survey($this->input,$this);
        }       
    }

    /**
     * task confirm
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function confirm()
    {
        $checkoutStatus = WishlistHelper::getCheckoutState();
        if ($checkoutStatus) {
            WishlistHelper::confirm($this->input,$this);
        }       
    } 

    /**
     * task checkoutPrint
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function checkoutPrint()
    {
        $checkoutStatus = WishlistHelper::getCheckoutState();
        if ($checkoutStatus) {
            WishlistHelper::checkout($this->input,$this);
            parent::display();
        }       
    }

    private function showConfirm($survey)
    {
        $showDelivery = false;
        $surveys = $this->getModel('Survey');
        $hasSurveys = is_null($surveys->getSurvey())?false:true;

        if (is_null($survey)) {
            $showDelivery = true;
        }
        elseif ($survey == 1)  {
            if (!$hasSurveys) 
                $showDelivery = false;
            else
                $showDelivery = true;
        }
        elseif ($survey == 0) {
            $showDelivery = true;
        }
        return $showDelivery;
    }   
}