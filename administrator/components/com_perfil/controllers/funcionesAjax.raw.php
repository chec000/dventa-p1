<?php

defined('_JEXEC') or die;

class PerfilControllerFuncionesAjax extends JControllerLegacy
{

    public function activateUser()
    {
        $app = JFactory::getApplication();

        $model = $this->getModel('perfiles');
        $task = $app->input->get('task', '');
        $token = $app->input->post->get('token', '');
        $userId = $app->input->post->get('id', '');
        $status = $app->input->post->get('status', '');

        $model->updateStatus($userId,$status);


    }

}