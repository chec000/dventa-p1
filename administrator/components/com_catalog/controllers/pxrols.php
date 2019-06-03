<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_catalog
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class catalogControllerpxrols extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    public function getModel($name = 'pxrol', $prefix = 'catalogModel', 
            $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function cancel()
    {
        $this->setRedirect(JRoute::_(
        'index.php?option=com_catalog&view=products', false));        
    }
    
    public function template()
    {
        ob_end_clean();
        $app = JFactory::getApplication();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=pxrols.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $template = <<<EOF
sku,rol,precio
CU000228,1,220
CU000228,2,230
CU000228,3,240
EOF;
        
        echo $template;
        $app->close();
    }        
}
