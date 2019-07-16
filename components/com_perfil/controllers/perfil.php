<?php

defined('_JEXEC') or die;

class PerfilControllerPerfil extends JControllerForm
{

    /**
     * PerfilControllerPerfil::save
     * @param type $key
     * @param type $urlVar
     * @return boolean
     */


    public function save($key = null, $urlVar = null)
    {


        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $jinput = JFactory::getApplication()->input;

        $app = JFactory::getApplication();
        
        $model = $this->getModel('perfil');
        $input = $app->input;
        $data = $input->get('jform', array(), 'array');
var_dump($data);
        die();
        $form = $model->getForm($data, false);

        $currentUri = JRoute::_('index.php?option=com_perfil', false);

        $context = $this->option . $this->context;

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
            // Save the form data in the session.
            $app->setUserState($context . '.data', $data);

            // Redirect back to the same screen.
            $this->setRedirect($currentUri);

            return false;
        }


        $user = JFactory::getUser();

        //if (!$model->updateData($validData, $userId, $jinput))
        if (!$model->updateData($data, $user->id, $jinput)) {
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

          $model->updateUser($params, $user->id);
        }
        $app->setUserState($context . '.data', null);
        $app->enqueueMessage(JText::_('COM_PERFIL_TEXT_SAVE'), 'message');
        $this->setRedirect(JRoute::_('index.php?Itemid=132'));

        return true;
    }

}
