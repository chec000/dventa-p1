<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class catalogModelpxrol extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'pxrol', $prefix = 'catalogTable', 
            $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * 
     * @param type $data
     * @param type $loadData
     * @return boolean
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_catalog.pxrol', 'pxrol', 
                array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
                return false;
        }
        return $form;
    }
    
    /**
     * 
     * @return type
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $app  = JFactory::getApplication();
        $data = $app->getUserState('com_catalog.edit.pxrol.data', array());
        if (empty($data))
        {
                $data = $this->getItem();
        }
        $this->preprocessData('com_catalog.pxrol', $data);
        return $data;
    }



}


