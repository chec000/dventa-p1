<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class catalogControllercuploads extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    public function getModel($name = 'cupload', $prefix = 'catalogModel', 
            $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function cancel()
    {
        $this->setRedirect(JRoute::_(
        'index.php?option=com_catalog&view=cxrols', false));        
    }
    
    public function lista()
    {
        $this->setRedirect(JRoute::_(
        'index.php?option=com_catalog&view=cuploads', false));         
    }        
}
