<?php
/**
 * @package     Joomla.Front
 * @subpackage  com_checkout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/CheckoutHelper.php';

class CheckoutController extends JControllerLegacy
{
    /**
     * View checkout
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function display($cachable = false, $urlparams = array())
    {
        $view = $this->input->get('view', 'Checkout');
        if ($view == 'survey' || $view == 'delivery' || $view == 'confirm' || $view == 'checkout')
        {
            $this->setRedirect(JRoute::_('index.php?option=com_checkout', false));
            return false;
        }

        $checkoutStatus = CheckoutHelper::getCheckoutState();
        if ($checkoutStatus) {
            $survey = self::getParams('survey');
            $showDelivery = self::showDelivery($survey);
            if($showDelivery)
                CheckoutHelper::delivery($this->input,$this);
            else
                CheckoutHelper::survey($this->input,$this);
            parent::display();    
        }        
    }

    public function getParams($key)
    {
        $params = JComponentHelper::getParams('com_catalog');
        return  $params[$key];
    }

    /**
     * View delivery
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function delivery()
    {
        $checkoutStatus = CheckoutHelper::getCheckoutState();
        if ($checkoutStatus) {
            CheckoutHelper::delivery($this->input,$this);
            parent::display(); 
        }           
    }

    public function autocompleteLocation()
    {
        CheckoutHelper::autocompleteLocation($this->input, $this);
        parent::display();
    }

    public function autocompleteCode()
    {
        CheckoutHelper::autocompleteCode($this->input, $this);
        parent::display();
    }

    public function autocompleteCity()
    {
        CheckoutHelper::autocompleteCity($this->input, $this);
        parent::display();
    }

    public function autocompleteTown()
    {
        CheckoutHelper::autocompleteTown($this->input, $this);
        parent::display();
    }

    /**
     * View confirm
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function confirm()
    {
        $checkoutStatus = CheckoutHelper::getCheckoutState();
        if ($checkoutStatus) {
            CheckoutHelper::confirm($this->input,$this);
            parent::display();
        }       
    } 

    /**
     * View checkoutPrint
     * 
     * @param type $cachable
     * @param type $urlparams
     */
    public function checkoutPrint()
    {
        $checkoutStatus = CheckoutHelper::getCheckoutState();
        if ($checkoutStatus) {
            CheckoutHelper::checkout($this->input,$this);
            parent::display();
        }       
    }

    private function showDelivery($survey)
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