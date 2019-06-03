<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  COM_CART
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/SuploadHelper.php';

class CartModelSupload extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'supload', $prefix = 'cartTable', 
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
        $form = $this->loadForm('com_cart.supload', 'supload', 
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
        $data = $app->getUserState('com_cart.edit.supload.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $this->preprocessData('com_cart.supload', $data);
        return $data;
    }

    public function save($data)
    {
        $data = SuploadHelper::setFile();
        return parent::save($data);
    }        

}