<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Pass_recovery
 * @author     Adventa <othon.parra@adventa.mx>
 * @copyright  2017 Adventa
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');


/**
 * Passrecoveries list controller class.
 *
 * @since  1.6
 */

class PerfilControllerPerfil extends JControllerAdmin
{



    public function getModel($name = 'perfil', $prefix = 'PerfilModel', $config = array('ignore_request' => true))
    {

        return parent::getModel($name, $prefix, $config);
    }


    public function save($key = null, $urlVar = null)
    {
        



        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $jinput = JFactory::getApplication()->input;

        $app = JFactory::getApplication();

        $model = $this->getModel('perfil');

        $input = $app->input;
        $data = $input->get('jform', array(), 'array');

        $form = $model->getForm($data, false);

        $currentUri = JRoute::_('index.php?option=com_perfil', false);

        //$context = $this->option . $this->context;

        if (!$form) {
            $app->enqueueMessage($model->getError(), 'error');
            $errors = $model->getErrors();
            // Display up to three validation messages to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }
            $this->setRedirect($currentUri);

            return false;
        }

        $jinput = JFactory::getApplication()->input;
        $userId     = $jinput->get('userId', 1, 'INT');

        
        if (!$model->updateData($data, $userId, $jinput)) {
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

            $this->setRedirect($currentUri);
        }
        if (isset($data['email']) || isset($data['name'])|| isset($data['password'])) {

            $params = array();
            if (isset($data['password'])) {
                $params['password'] = JUserHelper::hashPassword($data['password']);
            }
            if (isset($data['email'])) {
                $params['email'] = $data['email'];
            }
            if (isset($data['name'])) {
                $params['name'] = $data['name'];
            }

            $model->updateUser($params, $userId);
        }
        $app->enqueueMessage(JText::_('COM_PERFIL_TEXT_SAVE_PERFIL'), 'message');
        $this->setRedirect(JRoute::_('index.php?option=com_perfil'));

        return true;
    }

}