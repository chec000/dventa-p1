<?php

defined('_JEXEC') or die;

class PerfilController extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {

        if (JFactory::getUser()->id == 0) {
            return $this->setRedirect(JRoute::_('', true));
        }
        return parent::display($cachable, $urlparams);
    }

}
