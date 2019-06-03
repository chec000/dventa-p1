<?php
/**
 * 
 * El ámbito de $this no funciona debido al autoloader
 * de joomla por lo que cualquier método o atributo debe 
 * acceder se mediante self
 * 
 * @package     Joomla.Administrator
 * @subpackage  COM_CHECKOUT_STATUS
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
class Checkout_StatusHelper
{
    /**
     * 
     * @param type $_input
     * @param type $_this
     */
    public static function checkout(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'checkout_status');
        $_input->set('view', $vName);
        $view = $_this->getView('checkout_status','html');
        $view->data = $_input->getArray();
        $view->setModel( $_this->getModel('Config'));
    }

    public static function closeCheckout(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'checkout_status');
        $_input->set('view', $vName);
        $view = $_this->getView('checkout_status','html');
        $view->data = $_input->getArray();
        $view->action = 'close';
        $view->setModel( $_this->getModel('Config'));
    }

    public static function openCheckout(&$_input,&$_this)
    {
        $vName = $_input->get('view', 'checkout_status');
        $_input->set('view', $vName);
        $view = $_this->getView('checkout_status','html');
        $view->data = $_input->getArray();
        $view->action = 'open';
        $view->setModel( $_this->getModel('Config'));
    }

    public static function getActions()
    {
        $user   = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_checkout_status';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
    
    /**
     * Elementos de Helix
     * 
     */
    public static function addSubmenu()
    {
        JToolbarHelper::title(JText::_('COM_CHECKOUT_STATUS'), '');
        JHtmlSidebar::addEntry(JText::_('COM_CHECKOUT_STATUS_MENU_GENERAL_TITLE'),
            'index.php?option=com_checkout_status', 'checkout_status' );
        
        JHtmlSidebar::addEntry(JText::_('COM_CHECKOUT_STATUS_MENU_PROFILE_TITLE'),
            'index.php?option=com_checkout_status&view=cxrols', 'cxrols' );

        JHtmlSidebar::addEntry(JText::_('COM_CHECKOUT_STATUS_MENU_LOG_TITLE'),
            'index.php?option=com_checkout_status&view=clogs', 'clogs' );
    }  

    public static function getFormatedDate($timestamp)
    {
        return date('Y-m-d', $timestamp);
    }

    public static function getTimestamp(){
        date_default_timezone_set('America/Mexico_City');
        $date = new DateTime();
        $now = (int) $date->getTimestamp();
        return $now;
    }

    public static function checkInRange($start_date, $end_date, $date)
    {
        return (($date >= $start_date) && ($date <= $end_date));
    }

    public static function getComponentParams($component, $key)
    {
        $params = JComponentHelper::getParams($component);
        return  $params[$key];
    }   

    public static function sendMail($body, $subject, $mail)
    {
        $send = false;
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( 
            $config->get('mailfrom'),
            $config->get('fromname') 
        );

        $mailer->setSender($sender);
        $mailer->addRecipient($mail);
        $mailer->setSubject($subject);

        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        $send = $mailer->Send();
        return $send;
    }
}