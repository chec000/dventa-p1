<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_checkout_status
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(JPATH_COMPONENT.'/helpers/').'/helpers/Checkout_Status.php';

class Checkout_StatusModelCxrol extends JModelAdmin
{
    /**
     * 
     * @param type $type
     * @param type $prefix
     * @param type $config
     * @return type
     */
    public function getTable($type = 'Cxrol', $prefix = 'Checkout_StatusTable', 
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
        $form = $this->loadForm('com_checkout_status.cxrol', 'cxrol', 
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
        $app  = JFactory::getApplication();
        $data = $app->getUserState('com_checkout_status.edit.cxrol.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $data->start_date = Checkout_StatusHelper::getFormatedDate($data->start_date);
        $data->end_date = Checkout_StatusHelper::getFormatedDate($data->end_date);
        $this->preprocessData('com_checkout_status.cxrol', $data);
        return $data;
    }

    public function guardar($data)
    {
        $rol_id = isset($data['rol_id'])?$data['rol_id']:null;
        $start_date = isset($data['start_date'])?strtotime($data['start_date']):null;
        $end_date = isset($data['end_date'])?strtotime($data['end_date']):null;
        if (!is_null($rol_id) && !is_null($start_date) && !is_null($end_date)) {
            $params = array(
                'rolId' => $rol_id,
                'startDate' => $start_date,
                'endDate' => $end_date
            );
            if ($data['id'] == 0) 
                 $this->insertCheckout($params);
            else
                 $this->updateCheckout($params);

          $this->createLog('change', $this->getGroup($rol_id));
          $status = Checkout_StatusHelper::checkInRange(
            $start_date, $end_date, 
            Checkout_StatusHelper::getTimestamp());
          if ($status) {
            $mailParams = array(
              'profile' => $this->getGroup($rol_id),
              'startDate' => $data['start_date'],
              'endDate' => $data['end_date']
            );
            $this->sendMail($mailParams);
          }
        }
    }

    public function sendMail($params)
    {
      $canDo = $canDo = Checkout_StatusHelper::getActions();
      if ($canDo->get('core.create') || $canDo->get('core.edit')) {
        $params['date'] = date('Y-m-d H:i:s', Checkout_StatusHelper::getTimestamp());
        $emails = Checkout_StatusHelper::getComponentParams('com_checkout_status','checkout_emails');
        $emails = explode(',',$emails);
        $subject = JText::_('COM_CHECKOUT_STATUS_MAIL_SUBJECT');
        $body   = '<h2>'.JText::_('COM_CHECKOUT_STATUS_MAIL_BODY').'</h2>'
        . '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_TYPE') . $params['profile'] . '</div>'
        . '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_DATE') . $params['date'] . '</div>'
        . '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_STARTDATE') . $params['startDate'] . '</div>'
        . '<div>' . JText::_('COM_CHECKOUT_STATUS_MAIL_ENDDATE') . $params['endDate'] . '</div>';
        foreach ($emails as $email) {
          if ($email != '') {
            Checkout_StatusHelper::sendMail($body, $subject, trim($email));
          }
        }
      }
    }

    public function getGroup($id)
    {
      $results = array();
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $query
      ->select(array('c.id, c.title'))
      ->from($db->quoteName('#__usergroups', 'c'))
      ->where('c.id = ' . $db->Quote($id));

      $db->setQuery($query);

      $results = $db->loadObject();
      return $results->title;
    }

    public function insertCheckout($params)
    {
       $canDo = $canDo = Checkout_StatusHelper::getActions();
        if ($canDo->get('core.create')) {
          $db = $this->getDbo();
          $checkout = new stdClass();
          $checkout->rol_id = $params['rolId'];
          $checkout->start_date = $params['startDate'];
          $checkout->end_date = $params['endDate'];
          $db->insertObject('#__core_checkout_x_roles', $checkout);
        }
    }

    public function updateCheckout($params)
    {   
        $canDo = $canDo = Checkout_StatusHelper::getActions();
        if ($canDo->get('core.edit')) {
          $db = $this->getDbo();
          $query = $db->getQuery(true);

          $fields = array(
            $db->quoteName('start_date') . ' = ' . $db->quote($params['startDate']),
            $db->quoteName('end_date') . ' = ' . $db->quote($params['endDate'])
          );

          $conditions = array(
            $db->quoteName('rol_id') . ' = ' . $db->quote($params['rolId'])
          );

          $query->update($db->quoteName('#__core_checkout_x_roles'))
          ->set($fields)->where($conditions);

          $db->setQuery($query);

          $result = $db->execute();
        }
    }

    public function createLog($action, $type)
    {
      $params = array(
        'action' => $action,
        'type' => $type,
        'applied_at' => date('Y-m-d H:i:s', Checkout_StatusHelper::getTimestamp())
      );
      $log = JModelLegacy::getInstance('Clogm', 'Checkout_StatusModel');
      $log->createLog($params);
    }
}